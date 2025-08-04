import React from 'react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';

interface Props {
    auth?: {
        user?: {
            id: number;
            name: string;
            email: string;
            role: string;
        };
    };
    [key: string]: unknown;
}

export default function Welcome({ auth }: Props) {
    const features = [
        {
            icon: '📋',
            title: 'Worksheet Management',
            description: 'Handle production worksheets from creation to approval with complete status tracking.'
        },
        {
            icon: '🏭',
            title: 'Production Type Control',
            description: 'Determine internal production vs FOB with specialized workflows for each type.'
        },
        {
            icon: '💰',
            title: 'Multi-level Costing',
            description: 'Create detailed cost estimations with production and finance manager approval workflows.'
        },
        {
            icon: '🔬',
            title: 'Sample Production Tracking',
            description: 'Monitor every step from material preparation to QA with precise time tracking.'
        },
        {
            icon: '📦',
            title: 'Material Management',
            description: 'Track material requests, sourcing, and reception for internal production processes.'
        },
        {
            icon: '👥',
            title: 'Team & Role Management',
            description: 'Assign tasks to apparel and non-apparel teams with role-based access control.'
        }
    ];

    const steps = [
        { step: '1', title: 'Material Preparation', desc: 'Fabric & trims sourcing' },
        { step: '2', title: 'Pattern Data', desc: 'Technical specifications' },
        { step: '3', title: 'Cutting', desc: 'Precision material cutting' },
        { step: '4', title: 'Application', desc: 'Screen printing & decoration' },
        { step: '5', title: 'Sewing', desc: 'Assembly & construction' },
        { step: '6', title: 'Finishing', desc: 'Final touches & prep' },
        { step: '7', title: 'Quality Assurance', desc: 'Final inspection & approval' }
    ];

    if (auth?.user) {
        return (
            <AppShell>
                <div className="space-y-8">
                    {/* Hero Section */}
                    <div className="text-center space-y-4">
                        <h1 className="text-4xl font-bold text-gray-900 dark:text-white">
                            🏭 Production Monitoring System
                        </h1>
                        <p className="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                            Complete manufacturing process management from worksheet approval to final product QA
                        </p>
                        <div className="flex justify-center gap-4">
                            <Button asChild size="lg">
                                <a href="/production">View Dashboard</a>
                            </Button>
                            <Button variant="outline" size="lg" asChild>
                                <a href="/worksheets">Manage Worksheets</a>
                            </Button>
                        </div>
                    </div>

                    {/* Stats Overview */}
                    <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <Card>
                            <CardHeader className="pb-2">
                                <CardTitle className="text-sm font-medium text-gray-600 dark:text-gray-400">
                                    Active Worksheets
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="text-2xl font-bold">24</div>
                                <p className="text-xs text-green-600">+12% from last month</p>
                            </CardContent>
                        </Card>
                        <Card>
                            <CardHeader className="pb-2">
                                <CardTitle className="text-sm font-medium text-gray-600 dark:text-gray-400">
                                    Pending Approvals
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="text-2xl font-bold">7</div>
                                <p className="text-xs text-orange-600">Requires attention</p>
                            </CardContent>
                        </Card>
                        <Card>
                            <CardHeader className="pb-2">
                                <CardTitle className="text-sm font-medium text-gray-600 dark:text-gray-400">
                                    Samples in Production
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="text-2xl font-bold">18</div>
                                <p className="text-xs text-blue-600">Across 3 teams</p>
                            </CardContent>
                        </Card>
                        <Card>
                            <CardHeader className="pb-2">
                                <CardTitle className="text-sm font-medium text-gray-600 dark:text-gray-400">
                                    QA Completed
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="text-2xl font-bold">156</div>
                                <p className="text-xs text-green-600">This month</p>
                            </CardContent>
                        </Card>
                    </div>

                    {/* Production Process Flow */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                ⚙️ Sample Production Process
                            </CardTitle>
                            <CardDescription>
                                Complete workflow tracking from material preparation to quality assurance
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="grid grid-cols-1 md:grid-cols-7 gap-4">
                                {steps.map((step, index) => (
                                    <div key={step.step} className="text-center space-y-2">
                                        <div className="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto font-bold text-blue-600 dark:text-blue-400">
                                            {step.step}
                                        </div>
                                        <h4 className="font-semibold text-sm">{step.title}</h4>
                                        <p className="text-xs text-gray-600 dark:text-gray-400">{step.desc}</p>
                                        {index < steps.length - 1 && (
                                            <div className="hidden md:block absolute mt-6 ml-12 w-8 h-0.5 bg-gray-300 dark:bg-gray-600"></div>
                                        )}
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>

                    {/* Role-based Features */}
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {features.map((feature, index) => (
                            <Card key={index} className="hover:shadow-lg transition-shadow">
                                <CardHeader>
                                    <CardTitle className="flex items-center gap-3">
                                        <span className="text-2xl">{feature.icon}</span>
                                        {feature.title}
                                    </CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <CardDescription>{feature.description}</CardDescription>
                                </CardContent>
                            </Card>
                        ))}
                    </div>

                    {/* User Role Badge */}
                    <div className="text-center">
                        <p className="text-sm text-gray-600 dark:text-gray-400 mb-2">
                            You are logged in as:
                        </p>
                        <Badge variant="secondary" className="text-lg px-4 py-2 capitalize">
                            {auth.user.role.replace('_', ' ')} - {auth.user.name}
                        </Badge>
                    </div>
                </div>
            </AppShell>
        );
    }

    return (
        <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
            <div className="max-w-6xl mx-auto px-4 py-12">
                {/* Hero Section */}
                <div className="text-center space-y-6 mb-16">
                    <h1 className="text-5xl font-bold text-gray-900 dark:text-white">
                        🏭 Production Monitoring System
                    </h1>
                    <p className="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                        Complete manufacturing process management from worksheet approval to final product QA.
                        Track every step with precision and ensure quality at every stage.
                    </p>
                    <div className="flex justify-center gap-4">
                        <Button size="lg" asChild>
                            <a href="/login">Login to Dashboard</a>
                        </Button>
                        <Button variant="outline" size="lg" asChild>
                            <a href="/register">Get Started</a>
                        </Button>
                    </div>
                </div>

                {/* Key Features Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                    {features.map((feature, index) => (
                        <Card key={index} className="hover:shadow-xl transition-all duration-300 border-0 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm">
                            <CardHeader>
                                <CardTitle className="flex items-center gap-3 text-lg">
                                    <span className="text-3xl">{feature.icon}</span>
                                    {feature.title}
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                <CardDescription className="text-base">{feature.description}</CardDescription>
                            </CardContent>
                        </Card>
                    ))}
                </div>

                {/* Production Process Visualization */}
                <Card className="mb-16 border-0 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm">
                    <CardHeader className="text-center">
                        <CardTitle className="text-2xl flex items-center justify-center gap-3">
                            ⚙️ Sample Production Workflow
                        </CardTitle>
                        <CardDescription className="text-lg">
                            Every sample follows our 7-step quality assurance process
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="grid grid-cols-1 md:grid-cols-7 gap-6">
                            {steps.map((step, index) => (
                                <div key={step.step} className="text-center space-y-3 relative">
                                    <div className="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto font-bold text-white text-lg shadow-lg">
                                        {step.step}
                                    </div>
                                    <h4 className="font-semibold text-sm text-gray-900 dark:text-white">{step.title}</h4>
                                    <p className="text-xs text-gray-600 dark:text-gray-400">{step.desc}</p>
                                    {index < steps.length - 1 && (
                                        <div className="hidden md:block absolute top-8 left-16 w-full h-0.5 bg-gradient-to-r from-blue-300 to-indigo-300 dark:from-blue-600 dark:to-indigo-600"></div>
                                    )}
                                </div>
                            ))}
                        </div>
                    </CardContent>
                </Card>

                {/* CTA Section */}
                <div className="text-center bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl p-12">
                    <h2 className="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        Ready to Streamline Your Production?
                    </h2>
                    <p className="text-lg text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
                        Join manufacturing teams already using our system to track worksheets, manage costs, 
                        and ensure quality throughout their production process.
                    </p>
                    <div className="flex justify-center gap-6">
                        <Button size="lg" className="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700" asChild>
                            <a href="/register">Start Free Trial</a>
                        </Button>
                        <Button variant="outline" size="lg" asChild>
                            <a href="/login">Sign In</a>
                        </Button>
                    </div>
                </div>
            </div>
        </div>
    );
}