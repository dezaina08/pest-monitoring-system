import { defineStore } from 'pinia'
import Swal from 'sweetalert2'
import { useForm } from '@inertiajs/vue3'

export const useDeleteItemStore = defineStore('deleteItem', {
    state: () => ({
        deleteForm: useForm({}),
        selectedItems: [],
        selectAll: false,
    }),
    actions: {
        confirmDelete(url, id, name = null) {
            let title = name
                ? 'Delete ' + name + '?'
                : 'Are you sure?'

            Swal.fire({
                title: title,
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteItem(url, id)
                }
            })
        },
        deleteItem(url, id) {

            let id_array = Array.isArray(id)
                        ? Object.keys(id).map(index => id[index].id)
                        : [id]

            this.deleteForm.transform(() => ({
                    id_array: id_array,
                }))
                .delete(
                route(url + '.destroy', id),
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        Swal.fire({
                            title: 'Deleted successfully',
                            // text: "Deleted successfully.",
                            icon: 'success',
                            confirmButtonColor: '#16A34A',
                        })
                        this.selectedItems = []
                        this.selectAll = false
                    },
                    onError: (error) => {
                        Swal.fire({
                            title: 'Something went wrong',
                            text: error[0],
                            icon: 'error',
                            confirmButtonColor: '#d33',
                        })
                    },
                }
            )
        }
    },
})
