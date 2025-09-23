<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Contract;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with(['contract.room', 'contract.tenant'])
                          ->latest()
                          ->get();
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contracts = Contract::with(['room', 'tenant'])
                            ->where('status', 'active')
                            ->get();
        return view('payments.create', compact('contracts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:rent,deposit,electricity,water,other',
            'status' => 'required|in:paid,pending,overdue',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date|after_or_equal:payment_date'
        ]);

        Payment::create($request->all());

        return redirect()->route('payments.index')
                        ->with('success', 'Thanh toán được tạo thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment->load(['contract.room', 'contract.tenant']);
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $contracts = Contract::with(['room', 'tenant'])
                            ->where('status', 'active')
                            ->orWhere('id', $payment->contract_id)
                            ->get();
        return view('payments.edit', compact('payment', 'contracts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:rent,deposit,electricity,water,other',
            'status' => 'required|in:paid,pending,overdue',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date|after_or_equal:payment_date'
        ]);

        $payment->update($request->all());

        return redirect()->route('payments.index')
                        ->with('success', 'Thanh toán được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index')
                        ->with('success', 'Thanh toán được xóa thành công.');
    }
}