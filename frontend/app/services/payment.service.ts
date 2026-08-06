import { useApiClient } from '~/utils/api'

interface PaymentData {
  consultation_id: number;
  payment_method: string;
}

export const usePaymentService = () => {
  const api = useApiClient()

  const processPayment = async (data: PaymentData) => {
    return await api<{ message: string, data: any }>('/payments', {
      method: 'POST',
      body: data
    })
  }

  const getBooking = async (id: string | number) => {
    return await api<{ data: any }>(`/bookings/${id}`, {
      method: 'GET'
    })
  }

  return {
    processPayment,
    getBooking
  }
}
