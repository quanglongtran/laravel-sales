<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coupon\CreateCouponRequest;
use App\Http\Requests\Coupon\UpdateCouponRequest;
use App\Models\Coupon;
use App\Traits\PermissionMiddleware;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    use PermissionMiddleware;

    protected $coupon;

    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
        $this->setMidleware('coupon');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = $this->coupon->latest('id')->paginate();

        return view('admin.coupon.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCouponRequest $request)
    {
        $this->coupon->create($request->all());

        return redirect(route('admin.coupon.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = $this->coupon->find($id);

        return \view('admin.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCouponRequest $request, $id)
    {
        $coupon = $this->coupon->findOrFail($id);
        $coupon->update($request->all());

        return redirect(route('admin.coupon.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->coupon->destroy($id);
        \notify('Delete coupon successfully', null, 'success');
        return redirect(route('admin.coupon.index'));
    }
}
