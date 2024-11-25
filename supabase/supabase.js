const { createClient } = supabase;

const SUPABASE_URL = "https://cqxrkximqobjpoalshts.supabase.co";
const SUPABASE_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImNxeHJreGltcW9ianBvYWxzaHRzIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzAyNTEyMzYsImV4cCI6MjA0NTgyNzIzNn0.3azsYIhaD3QhQWhEtHMJDV_ri2So7zBTvyFMMHNIisg";

export const supabaseClient = createClient(SUPABASE_URL, SUPABASE_KEY);
