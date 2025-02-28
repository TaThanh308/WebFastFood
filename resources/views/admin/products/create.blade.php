@extends('layouts.admin')

@section('content')
    <h2>Thêm sản phẩm</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered">
                    <tr>
                        <th><label for="name">Tên sản phẩm:</label></th>
                        <td>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="category_id">Danh mục:</label></th>
                        <td>
                            <select name="category_id" id="category_id" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Giá:</th>
                        <td>
                            <div class="input-group">
                                <input type="number" name="price" class="form-control" required>
                                <span class="input-group-text">₫</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Kích thước (nếu có):</th>
                        <td>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="size[]" value="S" id="sizeS">
                                <label class="form-check-label" for="sizeS">S</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="size[]" value="M" id="sizeM">
                                <label class="form-check-label" for="sizeM">M</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="size[]" value="L" id="sizeL">
                                <label class="form-check-label" for="sizeL">L</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="size[]" value="XL" id="sizeXL">
                                <label class="form-check-label" for="sizeXL">XL</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="stock">Kho:</label></th>
                        <td>
                            <input type="number" name="stock" id="stock" class="form-control" required>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="description">Mô tả:</label></th>
                        <td>
                            <textarea name="description" id="description" class="form-control" required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="image">Ảnh:</label></th>
                        <td>
                            <input type="file" name="image" id="image" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">
                            <button type="submit" class="btn btn-primary">Thêm</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
@endsection
