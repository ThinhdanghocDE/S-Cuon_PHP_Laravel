@extends('admin/adminlayout')

@section('container')

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Sửa Bài Viết</h4>
            <br>
            @if(Session::has('wrong'))
                <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>Lỗi!</strong> {{Session::get('wrong')}}
                </div>
                <br>
            @endif
            @if(Session::has('success'))
                <div class="success">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>Thành công!</strong> {{Session::get('success')}}
                </div>
                <br>
            @endif

            <form class="forms-sample" action="{{ route('admin.posts.edit.process', $post->id) }}" method="post" enctype="multipart/form-data" id="postForm">
                @csrf

                <div class="form-group">
                    <label for="postTitle">Tiêu Đề <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" id="postTitle" value="{{ $post->title }}" required>
                </div>

                <div class="form-group">
                    <label for="postExcerpt">Tóm Tắt</label>
                    <textarea class="form-control" name="excerpt" id="postExcerpt" rows="3">{{ $post->excerpt }}</textarea>
                    <small class="form-text text-muted">Tối đa 500 ký tự</small>
                </div>

                <div class="form-group">
                    <label for="postContent">Nội Dung <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="content" id="postContent" rows="15" required>{{ $post->content }}</textarea>
                    <small class="form-text text-muted">Tối thiểu 50 ký tự</small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="postCategory">Danh Mục <span class="text-danger">*</span></label>
                            <select class="form-control" name="category" id="postCategory" required>
                                <option value="general" {{ $post->category == 'general' ? 'selected' : '' }}>Tổng hợp</option>
                                <option value="news" {{ $post->category == 'news' ? 'selected' : '' }}>Tin tức</option>
                                <option value="promotion" {{ $post->category == 'promotion' ? 'selected' : '' }}>Khuyến mãi</option>
                                <option value="recipe" {{ $post->category == 'recipe' ? 'selected' : '' }}>Công thức</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="postStatus">Trạng Thái <span class="text-danger">*</span></label>
                            <select class="form-control" name="status" id="postStatus" required>
                                <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>Nháp</option>
                                <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>Đã đăng</option>
                                <option value="archived" {{ $post->status == 'archived' ? 'selected' : '' }}>Lưu trữ</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="postImage">Ảnh Đại Diện</label>
                    @if($post->featured_image)
                        <div style="margin-bottom: 10px;">
                            <img src="{{ asset('assets/images/'.$post->featured_image) }}" alt="Ảnh hiện tại" style="max-width: 200px; height: auto; border-radius: 5px;">
                            <p class="text-muted" style="margin-top: 5px;">Ảnh hiện tại</p>
                        </div>
                    @endif
                    <div class="custom-file-input-wrapper">
                        <input type="file" name="featured_image" class="custom-file-input" id="postImage" accept="image/jpeg,image/jpg,image/png" onchange="updateFileName(this, 'postImageLabel')">
                        <label for="postImage" class="custom-file-label" id="postImageLabel">
                            <i class="mdi mdi-file-image"></i> Chọn file mới (nếu muốn thay đổi)
                        </label>
                        <span class="file-name-display" id="postImageFileName"></span>
                    </div>
                    <small class="form-text text-muted">Chỉ chấp nhận file JPG, JPEG, PNG. Kích thước tối đa: 5MB</small>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="is_featured" id="postFeatured" value="1" {{ $post->is_featured == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="postFeatured">
                            Đánh dấu bài viết nổi bật
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="postMetaTitle">SEO Title</label>
                    <input type="text" name="meta_title" class="form-control" id="postMetaTitle" value="{{ $post->meta_title }}" placeholder="Tiêu đề SEO (tùy chọn)">
                </div>

                <div class="form-group">
                    <label for="postMetaDescription">SEO Description</label>
                    <textarea class="form-control" name="meta_description" id="postMetaDescription" rows="2" placeholder="Mô tả SEO (tùy chọn)">{{ $post->meta_description }}</textarea>
                </div>
              
                <button type="submit" class="btn btn-primary me-2">Cập nhật</button>
                <a href="{{ route('admin.posts') }}" class="btn btn-dark">Hủy</a>
            </form>
        </div>
    </div>
</div>

<style>
.alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
    border-radius: 5px;
}

.success {
    padding: 20px;
    background-color: #4BB543;
    color: white;
    border-radius: 5px;
}

.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}

.closebtn:hover {
    color: black;
}

.custom-file-input-wrapper {
    position: relative;
    display: block;
    width: 100%;
}

.custom-file-input {
    position: absolute !important;
    left: -9999px !important;
    opacity: 0 !important;
    width: 0 !important;
    height: 0 !important;
    visibility: hidden !important;
    overflow: hidden !important;
    z-index: -1 !important;
    pointer-events: none !important;
}

.custom-file-label {
    display: inline-block;
    padding: 10px 20px;
    background-color: #f0f0f0;
    border: 1px solid #ddd;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.custom-file-label:hover {
    background-color: #e0e0e0;
}

.file-name-display {
    margin-left: 10px;
    color: #666;
    font-style: italic;
}
</style>

<script>
function updateFileName(input, labelId) {
    const fileName = input.files[0] ? input.files[0].name : '';
    const displayElement = document.getElementById(input.id + 'FileName');
    if (displayElement) {
        displayElement.textContent = fileName;
    }
}
</script>

@endsection

