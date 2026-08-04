export interface User {
  id: number;
  name: string;
  email: string;
  role: 'customer' | 'consultant' | 'admin';
  avatar_url?: string | null;
  created_at: string;
}

export interface AuthResponse {
  user: User;
  token: string;
}

export interface WorkingHour {
  id: number;
  day_of_week: number;
  start_time: string;
  end_time: string;
  is_closed: boolean;
}

export interface ConsultantProfile {
  id: number;
  slug: string;
  user: {
    id: number;
    name: string;
    avatar_url: string;
  };
  title: string;
  hourly_rate: number;
  bio: string;
  rating: number;
  reviews_count: number;
  tags: string[];
  is_active: boolean;
  working_hours?: WorkingHour[];
}
