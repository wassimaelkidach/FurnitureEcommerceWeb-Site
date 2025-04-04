@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
                

                               
<a class="tf-button style-1 w208" href="{{ route('admin.coupon.add') }}">
    <i class="icon-plus"></i> Add new
</a>
                                    </div>
                                    <div class="wg-table table-all-user">
                                        <div class="table-responsive">
                                        @if(session()->has('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Code</th>
                                                        <th>Type</th>
                                                        <th>Value</th>
                                                        <th>Cart Value</th>
                                                        <th>Expiry Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($coupons as $coupon)
<tr>
    <td>{{$coupon->id}}</td>
    <td>{{$coupon->code}}</td>
    <td>{{$coupon->type}}</td>
    <td>{{$coupon->value}}</td>
    <td>{{$coupon->cart_value}}</td>
    <td>{{$coupon->expiry_date}}</td>
    <td>
    <div class="list-icon-function">
    <!-- Bouton Modifier -->
    <a href="{{ route('admin.coupon.edit', $coupon->id) }}" class="btn-edit">
    <i class="icon-edit-3"></i> Edit
</a>
    
<form action="{{ route('admin.coupon.delete', $coupon->id) }}" method="POST">
    @csrf 
    @method('DELETE')
    <button type="submit" onclick="return confirm('Êtes-vous sûr ?')" class="delete-btn">
        <i class="icon-trash-2"></i>
    </button>
</form>

<style>
    .delete-btn {
        background-color: #f8f9fa; /* Couleur de fond neutre */
        border: 1px solid #dc3545; /* Bordure rouge */
        color: #dc3545; /* Icône rouge */
        width: 32px;
        height: 32px;
        border-radius: 50%; /* Forme circulaire */
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        padding: 0;
        margin: 0;
    }

    .delete-btn:hover {
        background-color: #dc3545; /* Fond rouge au survol */
        color: white; /* Icône blanche au survol */
        transform: scale(1.05); /* Légère augmentation de taille */
        box-shadow: 0 2px 5px rgba(220, 53, 69, 0.3); /* Ombre portée */
    }

    .delete-btn:active {
        transform: scale(0.98); /* Effet de clic */
    }

    .delete-btn i {
        font-size: 14px; /* Taille de l'icône */
    }
</style>
</div>

<style>
.btn-edit {
    color: #3490dc;
    transition: all 0.3s;
}
.btn-edit:hover {
    color: #1d68a7;
    transform: scale(1.1);
}
</style>
@endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
{{ $coupons->links('pagination::bootstrap-5') }}

                                    </div>
                                </div>
                            </div>
                        </div>
@endsection
@push('scripts')
<script>
    $(function() {
        $('.delete').on('click', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: "Are you sure?",
                text: "You want to delete this record?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                confirmButtonColor: '#dc3545'
            }).then(function(result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush