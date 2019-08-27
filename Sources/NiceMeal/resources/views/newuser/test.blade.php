<h1>upload</h1>
<form action="{{url('/upload-image')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image" id="image">
    <button type="submit">upload</button>
</form>