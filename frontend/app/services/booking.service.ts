import { useApiClient } from '~/utils/api'

interface BookingData {
  consultant_profile_id: number;
  start_time: string;
  duration_minutes: number;
}

export const useBookingService = () => {
  const api = useApiClient()

  const createBooking = async (data: BookingData) => {
    return await api<{ message: string, data: any }>('/bookings', {
      method: 'POST',
      body: data
    })
  }

  return {
    createBooking
  }
}
