<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexAdmin(Request $request, string $search = '')
    {
        if (request()->routeIs('admin.order.search') && empty($search)) {
            return redirect()->route('admin.order.index');
        }

        $show_compleated = $request->get('show_compleated') ?? '0';

        $orders = Order::orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->where('compleated', $show_compleated)
            ->where('client_name', 'LIKE', "%{$search}%")
            ->orWhere('id', $search);

        return Inertia::render('Admin/Order/Index', [
            'orders' => $orders->paginate(10),
            'showCompleated' => $request->get('show_compleated'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $order = Order::create($data);

            $data['order_id'] = $order->id;

            // form message from following template
            // 'client_name' => 'required|string|max:255',
            // 'client_phone' => 'required|string|max:255',
            // 'client_email' => 'required|string|regex:/(.+)@(.+)\.(.+)/i|max:255',
            // 'client_message' => 'nullable|string|max:255',
            // 'cart_content' => 'required|array',
            // 'shipping_message' => 'nullable|string|max:255',
            // 'status_name' => 'nullable|string|max:255',
            // 'status_color' => 'nullable|string|max:255',
            // 'compleated' => 'nullable|boolean',
            $messageText = "Нове замовлення №{$order->id} від {$order->client_name} на суму {$order->total_price} грн.
            Телефон: {$order->client_phone} 
            Email: {$order->client_email} 
            Коментар: {$order->client_message}  
            Доставка: {$order->shipping_message}
            Додані товари: ";
            foreach ($order->cart_content as $product) {
                $messageText .= "\n{$product['name']['ua']} - {$product['quantity']} шт. - {$product['price']}грн/шт.";
            }
            Mail::send('emails.newOrder', $data, function ($message) {
                $message->from('form-manager@gutgas.eu', 'Gutgas Sale manager');
                // $message->to('sale@gutgas.eu');
                $message->to('borysenko.alexander@gmail.com');
                $message->subject('$$$ Нове Замовлення $$$');
            });

            DB::commit();

            $bot_token = '6483041228:AAE77cZN7t_Fd-5_Bnz1kC_1NWj9MBhiNFo';
            $chat_id = '-4078811387';
            $text = urlencode($messageText);
            $url = "https://api.telegram.org/bot{$bot_token}/sendMessage?chat_id={$chat_id}&text={$text}";
            file_get_contents($url);

            return redirect()->route('thankYou')
                ->with('order', $order)->with('thankYouTranslations', trans('thank-you'));
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return Inertia::render('Admin/Order/Edit', [
            'order' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Order $order)
    {
        DB::beginTransaction();
        try {
            $order->update($request->validated());

            DB::commit();
            return redirect()->route('admin.order.edit', $order->id)->with('message', [
                'type' => 'success',
                'text' => 'Order updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        DB::beginTransaction();
        try {
            $order->delete();

            DB::commit();
            return redirect()->route('admin.order.index')->with('message', [
                'type' => 'success',
                'text' => 'Order deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
