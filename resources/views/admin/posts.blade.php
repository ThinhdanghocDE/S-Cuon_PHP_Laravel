@extends('admin/adminlayout')

@section('container')

<a href="{{ route('admin.posts.add') }}" type="button" class="btn btn-success" style="width:170px;height:35px;padding-top:9px;">+ Thêm Bài Viết</a>

<br>
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

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Danh Sách Bài Viết</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tiêu Đề</th>
                                <th>Danh Mục</th>
                                <th>Tác Giả</th>
                                <th>Trạng Thái</th>
                                <th>Nổi Bật</th>
                                <th>Lượt Xem</th>
                                <th>Ngày Tạo</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($posts as $post)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>
                                    <strong>{{ $post->title }}</strong>
                                    @if($post->is_featured == 1)
                                        <span class="badge badge-warning" style="margin-left: 5px;">Nổi bật</span>
                                    @endif
                                </td>
                                <td>
                                    @if($post->category == 'general')
                                        <span class="badge badge-info">Tổng hợp</span>
                                    @elseif($post->category == 'news')
                                        <span class="badge badge-primary">Tin tức</span>
                                    @elseif($post->category == 'promotion')
                                        <span class="badge badge-success">Khuyến mãi</span>
                                    @elseif($post->category == 'recipe')
                                        <span class="badge badge-warning">Công thức</span>
                                    @endif
                                </td>
                                <td>{{ $post->author_name }}</td>
                                <td>
                                    @if($post->status == 'draft')
                                        <span class="badge badge-secondary">Nháp</span>
                                    @elseif($post->status == 'published')
                                        <span class="badge badge-success">Đã đăng</span>
                                    @elseif($post->status == 'archived')
                                        <span class="badge badge-dark">Lưu trữ</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" 
                                            class="btn btn-sm {{ $post->is_featured == 1 ? 'btn-warning' : 'btn-outline-warning' }}"
                                            onclick="toggleFeatured({{ $post->id }}, this)">
                                        {{ $post->is_featured == 1 ? 'Có' : 'Không' }}
                                    </button>
                                </td>
                                <td>{{ number_format($post->views, 0, ',', '.') }}</td>
                                <td>{{ date('d/m/Y', strtotime($post->created_at)) }}</td>
                                <td>
                                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                                    <a href="{{ route('admin.posts.delete', $post->id) }}" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')">Xóa</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
</style>

<script>
function toggleFeatured(id, btn) {
    fetch(`/admin/posts/featured/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            if(data.is_featured == 1) {
                btn.classList.remove('btn-outline-warning');
                btn.classList.add('btn-warning');
                btn.textContent = 'Có';
            } else {
                btn.classList.remove('btn-warning');
                btn.classList.add('btn-outline-warning');
                btn.textContent = 'Không';
            }
            alert(data.message);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra!');
    });
}
</script>

@endsection

