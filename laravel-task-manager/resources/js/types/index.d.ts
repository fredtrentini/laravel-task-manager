import { InertiaLinkProps } from '@inertiajs/vue3';
import type { LucideIcon } from 'lucide-vue-next';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    created_at: string;
    updated_at: string;
}

export interface Project {
    id: number;
    title: string;
    description: string;
    start_date: string;
    end_date: string;
    file: string | null;
    created_at: string;
    updated_at: string;
    user_id: number;
}

export interface Task {
    id: number;
    title: string;
    description: string;
    due_date: string;
    priority: 1 | 2 | 3 | 4 | 5;
    status: 1 | 2 | 3;
    file: string | null;
    created_at: string;
    updated_at: string;
    project_id: number;
}

export type BreadcrumbItemType = BreadcrumbItem;

