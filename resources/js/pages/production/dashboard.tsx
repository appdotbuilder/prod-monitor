import React from 'react';
import { AppShell } from '@/components/app-shell';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Progress } from '@/components/ui/progress';

interface Worksheet {
    id: number;
    worksheet_number: string;
    product_name: string;
    status: string;
    production_type: string | null;
    creator: {
        name: string;
    };
    created_at: string;
}

interface Sample {
    id: number;
    sample_code: string;
    status: string;
    progress: number;
    worksheet: {
        product_name: string;
    };
    assigned_team: {
        name: string;
        type: string;
    } | null;
}

interface Stats {
    pending_worksheets: number;
    approved_worksheets: number;
    pending_costings: number;
    active_samples: number;
    pending_steps: number;
}

interface PendingApproval {
    id: number;
    worksheet_number?: string;
    product_name?: string;
    creator?: {
        name: string;
    };
    worksheet?: {
        product_name: string;
    };
}

interface Props {
    stats: Stats;
    recentWorksheets: Worksheet[];
    activeSamples: Sample[];
    pendingApprovals: PendingApproval[];
    [key: string]: unknown;
}

export default function ProductionDashboard({ 
    stats, 
    recentWorksheets, 
    activeSamples, 
    pendingApprovals 
}: Props) {
    const getStatusColor = (status: string) => {
        switch (status) {
            case 'pending': return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
            case 'approved': return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
            case 'rejected': return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
            case 'in_progress': return 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
            case 'completed': return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
            default: return 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
        }
    };

    const getProductionTypeColor = (type: string | null) => {
        switch (type) {
            case 'internal': return 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
            case 'fob': return 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300';
            default: return 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
        }
    };

    return (
        <AppShell>
            <div className="space-y-8">
                {/* Header */}
                <div className="flex justify-between items-center">
                    <Heading title="🏭 Production Monitoring Dashboard" />
                    <div className="flex gap-3">
                        <Button variant="outline" asChild>
                            <a href="/worksheets/create">New Worksheet</a>
                        </Button>
                        <Button asChild>
                            <a href="/costings/create">Create Costing</a>
                        </Button>
                    </div>
                </div>

                {/* Stats Overview */}
                <div className="grid grid-cols-1 md:grid-cols-5 gap-6">
                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-gray-600 dark:text-gray-400">
                                Pending Worksheets
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-3xl font-bold text-yellow-600">{stats.pending_worksheets}</div>
                            <p className="text-xs text-gray-600">Awaiting approval</p>
                        </CardContent>
                    </Card>
                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-gray-600 dark:text-gray-400">
                                Approved Worksheets
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-3xl font-bold text-green-600">{stats.approved_worksheets}</div>
                            <p className="text-xs text-gray-600">Ready for costing</p>
                        </CardContent>
                    </Card>
                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-gray-600 dark:text-gray-400">
                                Pending Costings
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-3xl font-bold text-orange-600">{stats.pending_costings}</div>
                            <p className="text-xs text-gray-600">Need approval</p>
                        </CardContent>
                    </Card>
                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-gray-600 dark:text-gray-400">
                                Active Samples
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-3xl font-bold text-blue-600">{stats.active_samples}</div>
                            <p className="text-xs text-gray-600">In production</p>
                        </CardContent>
                    </Card>
                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-gray-600 dark:text-gray-400">
                                Pending Steps
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-3xl font-bold text-purple-600">{stats.pending_steps}</div>
                            <p className="text-xs text-gray-600">Assigned tasks</p>
                        </CardContent>
                    </Card>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {/* Recent Worksheets */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                📋 Recent Worksheets
                            </CardTitle>
                            <CardDescription>
                                Latest worksheet submissions and their current status
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {recentWorksheets.map((worksheet) => (
                                    <div key={worksheet.id} className="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <div className="space-y-1">
                                            <div className="flex items-center gap-2">
                                                <span className="font-medium">{worksheet.worksheet_number}</span>
                                                <Badge className={getStatusColor(worksheet.status)}>
                                                    {worksheet.status}
                                                </Badge>
                                                {worksheet.production_type && (
                                                    <Badge variant="outline" className={getProductionTypeColor(worksheet.production_type)}>
                                                        {worksheet.production_type.toUpperCase()}
                                                    </Badge>
                                                )}
                                            </div>
                                            <p className="text-sm text-gray-600 dark:text-gray-400">{worksheet.product_name}</p>
                                            <p className="text-xs text-gray-500">by {worksheet.creator.name}</p>
                                        </div>
                                        <Button variant="ghost" size="sm" asChild>
                                            <a href={`/worksheets/${worksheet.id}`}>View</a>
                                        </Button>
                                    </div>
                                ))}
                                {recentWorksheets.length === 0 && (
                                    <p className="text-center text-gray-500 py-8">No worksheets found</p>
                                )}
                            </div>
                        </CardContent>
                    </Card>

                    {/* Active Samples */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                🔬 Active Samples
                            </CardTitle>
                            <CardDescription>
                                Samples currently in production with progress tracking
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {activeSamples.map((sample) => (
                                    <div key={sample.id} className="p-3 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <div className="flex items-center justify-between mb-2">
                                            <div className="flex items-center gap-2">
                                                <span className="font-medium">{sample.sample_code}</span>
                                                <Badge className={getStatusColor(sample.status)}>
                                                    {sample.status.replace('_', ' ')}
                                                </Badge>
                                            </div>
                                            <span className="text-sm font-medium">{sample.progress}%</span>
                                        </div>
                                        <p className="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                            {sample.worksheet.product_name}
                                        </p>
                                        <div className="flex items-center justify-between mb-2">
                                            <Progress value={sample.progress} className="flex-1 mr-4" />
                                            {sample.assigned_team && (
                                                <Badge variant="secondary" className="text-xs">
                                                    {sample.assigned_team.name} ({sample.assigned_team.type})
                                                </Badge>
                                            )}
                                        </div>
                                    </div>
                                ))}
                                {activeSamples.length === 0 && (
                                    <p className="text-center text-gray-500 py-8">No active samples</p>
                                )}
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Pending Approvals */}
                {pendingApprovals.length > 0 && (
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                ⏳ Pending Approvals
                            </CardTitle>
                            <CardDescription>
                                Items requiring your approval based on your role
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {pendingApprovals.map((item, index) => (
                                    <div key={index} className="p-4 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <div className="flex justify-between items-start">
                                            <div>
                                                <p className="font-medium">
                                                    {item.worksheet_number || `Costing #${item.id}`}
                                                </p>
                                                <p className="text-sm text-gray-600 dark:text-gray-400">
                                                    {item.product_name || item.worksheet?.product_name}
                                                </p>
                                                <p className="text-xs text-gray-500">
                                                    by {item.creator?.name}
                                                </p>
                                            </div>
                                            <Button size="sm" asChild>
                                                <a href={item.worksheet_number ? `/worksheets/${item.id}` : `/costings/${item.id}`}>
                                                    Review
                                                </a>
                                            </Button>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>
                )}

                {/* Quick Actions */}
                <Card>
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2">
                            ⚡ Quick Actions
                        </CardTitle>
                        <CardDescription>
                            Common tasks and navigation shortcuts
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <Button variant="outline" className="h-auto p-4 flex flex-col gap-2" asChild>
                                <a href="/worksheets">
                                    <span className="text-2xl">📋</span>
                                    <span>All Worksheets</span>
                                </a>
                            </Button>
                            <Button variant="outline" className="h-auto p-4 flex flex-col gap-2" asChild>
                                <a href="/costings">
                                    <span className="text-2xl">💰</span>
                                    <span>Costing Overview</span>
                                </a>
                            </Button>
                            <Button variant="outline" className="h-auto p-4 flex flex-col gap-2" asChild>
                                <a href="/samples">
                                    <span className="text-2xl">🔬</span>
                                    <span>Sample Tracking</span>
                                </a>
                            </Button>
                            <Button variant="outline" className="h-auto p-4 flex flex-col gap-2" asChild>
                                <a href="/materials">
                                    <span className="text-2xl">📦</span>
                                    <span>Material Requests</span>
                                </a>
                            </Button>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </AppShell>
    );
}