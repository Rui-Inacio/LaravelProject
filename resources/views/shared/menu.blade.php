<div class="pull-right">
    Welcome <strong><?= Auth::user()->name ?></strong>
    <form action="logout" method="POST" class="inline">
        {{csrf_field()}}
        <button class="btn btn-xs btn-default" type="submit">Logout</button>
    </form>
</div>
