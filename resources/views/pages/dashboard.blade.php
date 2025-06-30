@extends('layout')
@section('content')
<div>
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-gradient-to-r from-cyan-50 to-cyan-200 rounded-xl p-6 text-dark transform hover:scale-105 transition-transform duration-200 shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-graydark text-sm">Total Buku</p>
                                    <p class="text-3xl font-bold">1,234</p>
                                </div>
                                <div class="bg-cyan-600 bg-opacity-30 rounded-lg p-3">
                                    <i class="fas fa-book text-2xl px-1 text-center"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-green-50 to-green-200 rounded-xl p-6 text-graydark transform hover:scale-105 transition-transform duration-200 shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-graydark text-sm">Dipinjam Hari Ini</p>
                                    <p class="text-3xl font-bold">45</p>
                                </div>
                                <div class="bg-green-600 bg-opacity-30 rounded-lg p-3">
                                    <i class="fas fa-hand-holding-heart text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-purple-50 to-purple-200 rounded-xl p-6 text-graydark transform hover:scale-105 transition-transform duration-200 shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-graydark text-sm">Anggota Aktif</p>
                                    <p class="text-3xl font-bold">892</p>
                                </div>
                                <div class="bg-purple-600 bg-opacity-30 rounded-lg p-3">
                                    <i class="fas fa-users text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-orange-50 to-orange-200 rounded-xl p-6 text-graydark transform hover:scale-105 transition-transform duration-200 shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-graydark text-sm">Terlambat</p>
                                    <p class="text-3xl font-bold">12</p>
                                </div>
                                <div class="bg-orange-400 bg-opacity-30 rounded-lg p-3">
                                    <i class="fas fa-exclamation-triangle text-2xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Book Carousel -->
                    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-gray-800">Buku Terpopuler</h2>
                            <div class="flex space-x-2">
                                <button @click="prevSlide()" class="p-2 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors">
                                    <i class="fas fa-chevron-left text-gray-600"></i>
                                </button>
                                <button @click="nextSlide()" class="p-2 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors">
                                    <i class="fas fa-chevron-right text-gray-600"></i>
                                </button>
                            </div>
                        </div>

                        <div class="relative overflow-hidden">
                            <div class="flex transition-transform duration-500 ease-in-out"
                                 :style="`transform: translateX(-${currentSlide * 100}%)`">
                                <template x-for="(book, index) in popularBooks" :key="index">
                                    <div class="w-full flex-shrink-0 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                        <template x-for="item in book" :key="item.id">
                                            <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition-shadow cursor-pointer">
                                                <img :src="item.cover" :alt="item.title" class="w-full h-48 object-cover rounded-lg mb-3">
                                                <h3 class="font-semibold text-gray-800 text-sm mb-1" x-text="item.title"></h3>
                                                <p class="text-gray-600 text-xs mb-2" x-text="item.author"></p>
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center space-x-1">
                                                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                                                        <span class="text-xs text-gray-600" x-text="item.rating"></span>
                                                    </div>
                                                    <span class="text-xs text-blue-600 font-medium" x-text="`${item.borrowed} dipinjam`"></span>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Charts and Activity -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Activity Chart -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Aktivitas Peminjaman</h3>
                            <div class="h-64 bg-gradient-to-t from-blue-100 to-transparent rounded-lg flex items-end justify-center">
                                <div class="text-center">
                                    <i class="fas fa-chart-line text-4xl text-blue-500 mb-2"></i>
                                    <p class="text-gray-600">Grafik Aktivitas</p>
                                </div>
                            </div>
                        </div>

                        <!-- Top Users -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Top 10 Anggota Aktif</h3>
                            <div class="space-y-3">
                                <template x-for="(user, index) in topUsers" :key="user.id">
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-gradient-to-r from-blue-200 to-blue-400 rounded-full flex items-center justify-center text-white font-bold text-sm"
                                                 x-text="index + 1"></div>
                                            <div>
                                                <p class="font-medium text-gray-800 text-sm" x-text="user.name"></p>
                                                <p class="text-gray-500 text-xs" x-text="`${user.books} buku dipinjam`"></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-sm font-bold text-yellow-500" x-text="`${user.points} pts`"></span>
                                            <i class="fas fa-trophy text-yellow-400"></i>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
@endsection
