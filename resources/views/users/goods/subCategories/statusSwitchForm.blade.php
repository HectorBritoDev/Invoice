@if ($subCategory->status==true)

<form action="{{ route('goodServiceSubCategory.update',$subCategory) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="status" id="status" value="0">
    <button type="submit" class="btn btn-link"><i class="fas fa-lightbulb yellow" aria-hidden="true"></i></button>
</form>

@else
<form action="{{ route('goodServiceSubCategory.update',$subCategory) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="status" id="status" value="1">
    <button type="submit" class="btn btn-link"><i class="fas fa-lightbulb red" aria-hidden="true"></i></button>
</form>
@endif
