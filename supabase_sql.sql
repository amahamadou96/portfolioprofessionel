-- Supabase SQL: Exécutez ce script dans Supabase SQL Editor

-- Create contact_messages table
create table if not exists public.contact_messages (
  id bigserial primary key,
  name text not null,
  email text not null,
  message text not null,
  status text default 'unread',
  created_at timestamptz default now()
);

-- Create email_logs table
create table if not exists public.email_logs (
  id bigserial primary key,
  message_id bigint,
  recipient_email text not null,
  sender_email text not null,
  subject text not null,
  status text default 'pending',
  error_message text,
  created_at timestamptz default now()
);

-- Enable RLS (Row Level Security) - optional but recommended
alter table public.contact_messages enable row level security;
alter table public.email_logs enable row level security;

-- Policy pour permettre inserts via service_role uniquement
create policy "Allow insert from service_role" on public.contact_messages
  for insert 
  to service_role
  with check (true);

create policy "Allow insert from service_role" on public.email_logs
  for insert 
  to service_role
  with check (true);
