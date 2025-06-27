<div class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-900 to-blue-800 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <!-- Logo -->
            <div class="flex items-center justify-center h-16 px-4 bg-blue-900 shadow-lg">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <i class="fas fa-book text-blue-900 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-lg">DigiLib</h1>
                        <p class="text-blue-200 text-xs">Perpustakaan Digital</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-6 px-4 space-y-2">
                <template x-for="item in navigation" :key="item.name">
                    <div>
                        <a href="#"
                           @click.prevent="setActiveMenu(item.name)"
                           class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-blue-700 hover:shadow-md transform hover:scale-105"
                           :class="activeMenu === item.name ? 'bg-blue-700 text-white shadow-lg' : 'text-blue-200 hover:text-white'">
                            <i :class="item.icon" class="w-5 h-5 mr-3"></i>
                            <span x-text="item.name"></span>
                            <span x-show="item.badge"
                                  class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1"
                                  x-text="item.badge"></span>
                        </a>

                        <!-- Submenu -->
                        <div x-show="item.submenu && activeMenu === item.name"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="ml-8 mt-2 space-y-1">
                            <template x-for="subitem in item.submenu" :key="subitem.name">
                                <a href="#"
                                   @click.prevent="setActiveSubmenu(subitem.name)"
                                   class="block px-4 py-2 text-sm text-blue-200 hover:text-white hover:bg-blue-700 rounded-lg transition-colors duration-200"
                                   :class="activeSubmenu === subitem.name ? 'bg-blue-700 text-white' : ''"
                                   x-text="subitem.name"></a>
                            </template>
                        </div>
                    </div>
                </template>
            </nav>

            <!-- User Profile -->
            <div class="absolute bottom-0 left-0 right-0 p-4 bg-blue-900">
                <div class="flex items-center space-x-3 p-3 bg-blue-800 rounded-lg">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=3B82F6&color=fff"
                         alt="Avatar" class="w-10 h-10 rounded-full">
                    <div class="flex-1">
                        <p class="text-white font-medium text-sm">Admin User</p>
                        <p class="text-blue-200 text-xs">administrator</p>
                    </div>
                    <button class="text-blue-200 hover:text-white transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
            </div>
        </div>
