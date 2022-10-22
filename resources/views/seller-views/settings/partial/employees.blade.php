
@extends('layouts.back-end.app-seller')

@section('title', 'الاعدادات')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">الاعدادات</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-12">
                @include('seller-views.settings.sidebar')
            </div>
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">اضافة موظف</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable"
                                   style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                   class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                   style="width: 100%">
                                <thead class="thead-light">
                                <tr>
                                    <th>صورة الموظف</th>
                                    <th>اسم الموظف</th>
                                    <th>ايميل الموظف</th>
                                    <th>رقم الهاتف</th>
                                    <th>الوظيفة</th>
                                    <th>الفرع</th>
                                    <th>الاجراءات</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <img src="https://t4.ftcdn.net/jpg/02/29/75/83/360_F_229758328_7x8jwCwjtBMmC6rgFzLFhZoEpLobB6L8.jpg" alt="" width="100">
                                        </td>
                                        <td>مدحت صالح</td>
                                        <td>medhat@gmail.com</td>
                                        <td>01201234567</td>
                                        <td>بائع</td>
                                        <td>فرع صنعاء</td>
                                        <td>
                                            <a href="" class="btn btn-primary btn-sm" style="background: #645cb3;border:none;">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">اضافة موظف</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form action="">
                <div class="form-group">
                    <input type="text" class="form-control rounded-pill" name="name" placeholder="اسم الموظف">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control rounded-pill" name="phone" placeholder="رقم الموظف">
                </div>
                <div class="form-group">
                    <select name="role_id" class="form-control rounded-pill">
                        <option value="" selected>اختر الصلاحية</option>
                        <option value="">owner</option>
                        <option value="">Admin</option>
                        <option value="">Employer</option>
                    </select>
                </div>
                <div class="form-group">
                    <select name="branche_id" class="form-control rounded-pill select2" multiple>
                    </select>
                </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">حفظ</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
            </div>
        </div>
        </div>
    </div>

@endsection

@push('script_2')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>

<script>
    $('.select2').select2({
        data: ["فرع صنعاء", "فرع شبوة"],
        tags: true,
        maximumSelectionLength: 10,
        tokenSeparators: [',', ' '],
        placeholder: "اختر الفروع",
        //minimumInputLength: 1,
        //ajax: {
       //   url: "you url to data",
       //   dataType: 'json',
        //  quietMillis: 250,
        //  data: function (term, page) {
        //     return {
        //         q: term, // search term
        //    };
       //  },
       //  results: function (data, page) {
       //  return { results: data.items };
      //   },
      //   cache: true
       // }
    });
</script>

@endpush
