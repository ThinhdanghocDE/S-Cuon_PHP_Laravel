@extends('admin/adminlayout')

@section('container')


@foreach($customize as $custo)

<div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Edit Template</h4>
                    <br>

                    @if(Session::has('wrong'))
              
                        <div class="alert">
                      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                      <strong>Opps !</strong> {{Session::get('wrong')}}
                    </div>
                    <br>
                        @endif
                        @if(Session::has('success'))
                  
                        <div class="success">
                      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                      <strong>Congrats !</strong> {{Session::get('success')}}
                    </div>
                        <br>
                        @endif

                    <form class="forms-sample" action="{{ url('/customize_edit_process') }}" method="post" enctype="multipart/form-data">

                       @csrf

                      <div class="form-group">
                        <label for="exampleInputName1">Title</label>
                        <input type="text" name="title" value="{{  $custo->title  }}" class="form-control" id="exampleInputName1">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Description</label>

                        <textarea  cols="30" name="description" class="form-control" id="exampleInputName1" rows="5">{{  $custo->description  }}</textarea>
                    
                      </div>


                      <div class="form-group">
                        <label for="exampleFormControlFile1">Section Image 1</label>
                        <input type="file" name="image1" class="form-control-file" id="exampleFormControlFile1">
                      </div>

                      <div class="form-group">
                        <label for="exampleFormControlFile1">Section Image 2</label>
                        <input type="file" name="image2" class="form-control-file" id="exampleFormControlFile1">
                      </div>


                      <div class="form-group">
                        <label for="exampleFormControlFile1">Section Image 3</label>
                        <input type="file" name="image3" class="form-control-file" id="exampleFormControlFile1">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Youtube Video Link (Tùy chọn - nếu không upload video)</label>
                        <input type="text" name="youtube_video_link" value="{{  $custo->youtube_link  }}" class="form-control" id="exampleInputName1" placeholder="https://www.youtube.com/embed/...">
                        <small class="form-text text-muted">Chỉ điền nếu bạn muốn dùng link YouTube thay vì upload video</small>
                      </div>
                  
                      <div class="form-group">
                        <label for="exampleFormControlFile1">Upload Video File (MP4, WebM, OGG)</label>
                        <input type="file" name="video_file" class="form-control-file" id="exampleFormControlFile1" accept="video/mp4,video/webm,video/ogg">
                        <small class="form-text text-muted">Upload video trực tiếp lên web. Định dạng: MP4, WebM, OGG. Kích thước tối đa: 50MB</small>
                        @if($custo->video_file)
                            <p class="text-success mt-2">Video hiện tại: {{ $custo->video_file }}</p>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="exampleFormControlFile1">Video Thumbnail (Ảnh đại diện)</label>
                        <input type="file" name="image4" class="form-control-file" id="exampleFormControlFile1">
                        <small class="form-text text-muted">Ảnh hiển thị trước khi phát video</small>
                      </div>
                    
                      <button type="submit" class="btn btn-primary me-2">Update</button>
                      <a href="/admin/customize" class="btn btn-dark">Cancel</a>
                    </form>
                  </div>
                </div>

            </div>



@endsection()


@endforeach

<style>
.alert {
  padding: 20px;
  background-color: #f44336;
  color: white;
}

.success {
  padding: 20px;
  background-color: #4BB543 ;
  color: white;
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