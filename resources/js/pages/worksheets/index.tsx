import React from 'react';
import { AppShell } from '@/components/app-shell';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';

interface Worksheet {
    id: number;
    worksheet_number: string;
    product_name: string;
    description: string | null;
    status: string;
    production_type: string | null;
    creator: {
        name: string;
    };
    approver?: {
        name: string;
    };
    created_at: string;
    approved_at: string | null;
    costings: unknown[];
    samples: unknown[];
}

interface PaginationData {
    data: Worksheet[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}

interface Props {
    worksheets: PaginationData;
    [key: string]: unknown;
}

export default function WorksheetsIndex({ worksheets }: Props) {
    const getStatusColor = (status: string) => {
        switch (status) {
            case 'pending': return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
            case 'approved': return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
            case 'rejected': return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
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

    const formatDate = (dateString: string) => {
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    };

    return (
        <AppShell>
            <div className="space-y-6">
                {/* Header */}
                <div className="flex justify-between items-center">
                    <Heading title="📋 Worksheet Management" />
                    <Button asChild>
                        <a href="/worksheets/create">Create New Worksheet</a>
                    </Button>
                </div>

                {/* Summary Stats */}
                <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-gray-600 dark:text-gray-400">
                                Total Worksheets
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">{worksheets.total}</div>
                        </CardContent>
                    </Card>
                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-gray-600 dark:text-gray-400">
                                Pending Approval
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-yellow-600">
                                {worksheets.data.filter(w => w.status === 'pending').length}
                            </div>
                        </CardContent>
                    </Card>
                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-gray-600 dark:text-gray-400">
                                Approved
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-green-600">
                                {worksheets.data.filter(w => w.status === 'approved').length}
                            </div>
                        </CardContent>
                    </Card>
                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-gray-600 dark:text-gray-400">
                                With Samples
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-blue-600">
                                {worksheets.data.filter(w => w.samples.length > 0).length}
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Worksheets List */}
                <Card>
                    <CardHeader>
                        <CardTitle>All Worksheets</CardTitle>
                        <CardDescription>
                            Manage and track all production worksheets
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="space-y-4">
                            {worksheets.data.map((worksheet) => (
                                <div key={worksheet.id} className="border rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                    <div className="flex justify-between items-start">
                                        <div className="space-y-2 flex-1">
                                            <div className="flex items-center gap-3">
                                                <h3 className="font-semibold text-lg">{worksheet.worksheet_number}</h3>
                                                <Badge className={getStatusColor(worksheet.status)}>
                                                    {worksheet.status}
                                                </Badge>
                                                {worksheet.production_type && (
                                                    <Badge variant="outline" className={getProductionTypeColor(worksheet.production_type)}>
                                                        {worksheet.production_type.toUpperCase()}
                                                    </Badge>
                                                )}
                                            </div>
                                            
                                            <h4 className="text-xl font-medium text-gray-900 dark:text-white">
                                                {worksheet.product_name}
                                            </h4>
                                            
                                            {worksheet.description && (
                                                <p className="text-gray-600 dark:text-gray-300">
                                                    {worksheet.description}
                                                </p>
                                            )}
                                            
                                            <div className="flex items-center gap-6 text-sm text-gray-500">
                                                <span>Created by {worksheet.creator.name}</span>
                                                <span>Created {formatDate(worksheet.created_at)}</span>
                                                {worksheet.approver && worksheet.approved_at && (
                                                    <>
                                                        <span>Approved by {worksheet.approver.name}</span>
                                                        <span>Approved {formatDate(worksheet.approved_at)}</span>
                                                    </>
                                                )}
                                            </div>
                                            
                                            <div className="flex items-center gap-4 text-sm">
                                                <span className="flex items-center gap-1">
                                                    💰 <strong>{worksheet.costings.length}</strong> costing{worksheet.costings.length !== 1 ? 's' : ''}
                                                </span>
                                                <span className="flex items-center gap-1">
                                                    🔬 <strong>{worksheet.samples.length}</strong> sample{worksheet.samples.length !== 1 ? 's' : ''}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div className="flex gap-2">
                                            <Button variant="outline" size="sm" asChild>
                                                <a href={`/worksheets/${worksheet.id}`}>View Details</a>
                                            </Button>
                                            <Button variant="ghost" size="sm" asChild>
                                                <a href={`/worksheets/${worksheet.id}/edit`}>Edit</a>
                                            </Button>
                                        </div>
                                    </div>
                                </div>
                            ))}
                            
                            {worksheets.data.length === 0 && (
                                <div className="text-center py-12">
                                    <p className="text-gray-500 text-lg">No worksheets found</p>
                                    <p className="text-gray-400 mt-2">Create your first worksheet to get started</p>
                                    <Button className="mt-4" asChild>
                                        <a href="/worksheets/create">Create Worksheet</a>
                                    </Button>
                                </div>
                            )}
                        </div>
                        
                        {/* Pagination */}
                        {worksheets.last_page > 1 && (
                            <div className="flex justify-center gap-2 mt-6">
                                {Array.from({ length: worksheets.last_page }, (_, i) => i + 1).map((page) => (
                                    <Button
                                        key={page}
                                        variant={page === worksheets.current_page ? "default" : "outline"}
                                        size="sm"
                                        asChild
                                    >
                                        <a href={`/worksheets?page=${page}`}>{page}</a>
                                    </Button>
                                ))}
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>
        </AppShell>
    );
}