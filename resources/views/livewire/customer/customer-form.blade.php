<div>
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg">Nuevo cliente</button>
    <div class="modal fade bd-example-modal-lg" wire:ignore.self id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"aria-hidden="true">
        <div class="modal-dialog modal-lg" style="max-width:1500px;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="handleFormSubmit" class="text-left">
                        @include('livewire.customer._partials.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('stack_js')
    <script>
        Livewire.on('updateClients',() => {
            $('#exampleModal').modal('hide')
            Swal.fire({
                title: 'Cliente creado',
                icon: 'success',
                toast: true,
                timer: 5000,
                showConfirmButton: false,
                position: 'top-end'            
            })
        })
        const select2Config = {
            width: '100%',
            minimumInputLength: 2,
            language: {
                inputTooShort: () => {
                    return "Por favor escriba 2 o más carácteres"
                },
                noResults: () => {
                    return "No se han encontrado resultados"
                },
                searching: () => {
                    return "Buscando..."
                }
            }
        }
        const customerFields = () => {
            $('#city').select2(select2Config)
            $('#city').on('change',() => {
                var data = $('#city').select2('val')
                @this.set('city',data)
            })
            $('#postcode').select2(select2Config)
            $("#postcode").on('change',() => {
                var data = $("#postcode").select2('val')
                @this.set('postCode',data)
            })
            // $('#country').select2(select2Config)
            // $('#payment').select2(select2Config)
            // $('#payment_term').select2(select2Config)
            // $('#division').select2(select2Config)
        }

        Livewire.on('updateFields',customerFields)
        customerFields()
    </script>
@endpush