<div class="modal-body">
    <p>Está seguro de eliminar la categoría <strong><span id="cName"></span></strong>?</p>
</div>
<div class="modal-footer">
    {!! Form::open(['method' => 'DELETE', 'id'=>'delForm']) !!}
        <button type="submit" class="btn btn-danger">Sí, eliminar</button>
     {!! Form::close() !!}
</div>