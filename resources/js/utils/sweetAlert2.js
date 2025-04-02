import Swal from 'sweetalert2'
import { staticPrimaryColor } from '@/Plugins/theme'
import { router } from '@inertiajs/vue3'

export const swToast = (title, icon, timer) => {
  // success, error, warning, info, question
  return Swal.fire({
    icon: icon || 'success',
    title: title || 'Salvo com sucesso!',
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: timer || 1500
  })
}

export const swDeleteConfirm = async (route, title, text, icon) => {
  const result = await Swal.fire({
    title: title || 'Tem certeza?',
    text: text || 'Você não será capaz de reverter isso!',
    icon: icon || 'question',
    showCancelButton: true,
    confirmButtonColor: staticPrimaryColor,
    confirmButtonText: 'Sim, deletar!',
    cancelButtonColor: '#EA5455',
    cancelButtonText: 'Não, cancela!',
    reverseButtons: true
  })
  if (result.isConfirmed) {
    // console.log(route)
    router.delete(route, {
      preserveState: false,
      preserveScroll: true
    })
  }
}

export const swDeleteQuestion = async (item, route) => {
  const result = await Swal.fire({
    title: 'Muita atenção!',
    html: `
      Você está prestes a excluir <span class="text-warning">
      <i>${item}!</i>
      </span>`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: staticPrimaryColor,
    confirmButtonText: 'Continuar!',
    cancelButtonColor: '#EA5455',
    cancelButtonText: 'Não, cancela!',
    reverseButtons: true
  })
  if (result.isConfirmed) {
    swDeleteConfirm(route)
  }
}
