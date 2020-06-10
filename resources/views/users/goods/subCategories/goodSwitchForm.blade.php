@if ($subCategory->good==true)


<button type="button" class="btn btn-link"><i class="fas fa-check-square green" aria-hidden="true"></i></button>


@else
<form action="{{ route('goodServiceSubCategory.update',$subCategory) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="good" id="good" value="1">
    <button type="submit" class="btn btn-link"><i class="fas fa-check-square red" aria-hidden="true"></i></button>
</form>
@endif
