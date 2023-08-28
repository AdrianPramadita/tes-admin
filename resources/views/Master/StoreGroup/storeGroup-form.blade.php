
<!-- /Start Form  -->
<form class="form" id="btn-submit">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Group Store
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form">
                            {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Group Code</label>
                                    <input type="text" id="store-group-code-column" class="form-control" placeholder="Please Enter Code" name="store-group-code-column" value="{{ isset($data) ? $data->store_group_code : '' }}" {{ $disabled }}>
                                </div>
                                <div class="form-group">
                                    <label>Group Description</label>
                                    <input type="text" id="store-group-desc-column" class="form-control" placeholder="Please Enter Description Group" name="store-group-desc-column" value="{{ isset($data) ? $data->store_group_desc : '' }}" {{ $disabled }}>
                                </div>
                                <div class="form-group">
                                    <label>File input</label>
                                    <input type="file"> 
                                </div>
                                    <button type="button" class="btn btn-primary " id="btn-submit">Submit</button>
                                    <button type="reset" class="btn btn-default" onClick="window.history.back()">Back</button>
                            </form>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-6">
                            <h4>Disabled Form States</h4>
                            <form role="form">
                                <fieldset disabled="">
                                    <div class="form-group">
                                        <label for="disabledSelect">Disabled input</label>
                                        <input class="form-control" id="disabledInput" type="text" placeholder="Disabled input" disabled="">
                                    </div>
                                    <div class="form-group">
                                        <label for="disabledSelect">Disabled select menu</label>
                                        <select id="disabledSelect" class="form-control">
                                            <option>Disabled select</option>
                                        </select>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /End Form -->
    </div>
</form>


