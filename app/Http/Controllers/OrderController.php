<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        DB::beginTransaction();
        try {
            $order = Order::create($request->validated());

            DB::commit();
            return Inertia::render('ThankYou')->with('order', $order)->with('thankYouTranslations', trans('thank-you'));
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
