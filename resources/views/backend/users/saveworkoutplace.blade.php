  <!-- /.card -->
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body table-responsive csv">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="fit">S.No.</th>
                                    <th class="fit">Place Title</th>
                                   
                                    <th class="fit">Action</th>
                                </tr>
                            </thead>
                            <tbody>
    @foreach(@$allplaces as $key=>$value)
                    <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $value->title }}</td>
                    
                           
                       <td class="fit" style="text-align:center;">
                          
                            <a href="javascript:void(0);" data-token="{{ csrf_token() }}" class="" onclick="deleteathlete('{{@$value->id}}')">
                                <i class="fa fa-fw fa-trash" title="delete" style="color: red;"></i>
                            </a>
                            <a data-id="{{$value->id}}" class= "adduser">
                            <i title="edit" class="fa fa-edit" style="position: relative; margin-left:7px;color:#3c8dbc !important"></i></a> 
                           
                        </td> 
                    </tr>
    @endforeach
   
</tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                         
                        <!-- /.card-body -->
                    </div>
                                
                </div>