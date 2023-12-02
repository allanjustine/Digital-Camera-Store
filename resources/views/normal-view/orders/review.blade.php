@extends('normal-view.layout.base')

@section('title')
    | {{ $order->product->product_name }} rating and review
@endsection

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6>Send rating and review for <strong>{{ $order->product->product_name }}</strong></h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('review.rating.order', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <div class="form-outline">
                                    <select name="rating" id="rating"
                                        class="form-select @error('rating') is-invalid @enderror" name="rating"
                                        autocomplete="rating" autofocus>
                                        <option selected hidden value="">How would you rate this product?</option>
                                        <option disabled>How would you rate this product?</option>
                                        <option value="1">1 &#9733;</option>
                                        <option value="2">2 &#9733;&#9733;</option>
                                        <option value="3">3 &#9733;&#9733;&#9733;</option>
                                        <option value="4">4 &#9733;&#9733;&#9733;&#9733;</option>
                                        <option value="5">5 &#9733;&#9733;&#9733;&#9733;&#9733;</option>
                                    </select>
                                    <label class="form-label" for="rating">How would you rate this product?</label>
                                    @error('rating')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="form-outline">
                                    <textarea type="text" id="comment" name="comment" rows="5"
                                        class="form-control @error('comment') is-invalid @enderror" autocomplete="comment" autofocus>{{ old('comment') }}</textarea>
                                    <label for="comment">How was your experience about the product?</label>
                                    @error('comment')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block w-100"><i
                                    class="far fa-paper-plane"></i> Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
