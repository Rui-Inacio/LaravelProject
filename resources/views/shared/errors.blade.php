<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

	<div class="content">
		<div class="row">
			<div class="col-2"></div>
				<div class="col-8">
					<ul>
				    @foreach ($errors->all() as $error)
				        <li>{{$error}}</li>
				    @endforeach
				    </ul>
				</div>
			<div class="col-2"></div>
		</div>
	</div>
</div>


