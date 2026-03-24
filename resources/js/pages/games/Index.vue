<script setup lang="ts">
import { Head, router, Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';

defineProps<{
    games: Array<{
        id: number;
        title: string;
        cover_url: string;
        platform: string;
        genre: string;
        source: string;
    }>;
}>();
</script>

<template>
    <AppLayout>
        <Head title="Mes Jeux" />

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex items-start justify-between">
                <Heading
                    title="Mes Jeux"
                    description="Gérez votre bibliothèque de jeux et vos sessions."
                />
                <Button @click="router.visit('/games/create')">
                    Ajouter un jeu
                </Button>
            </div>

            <div
                class="overflow-hidden rounded-lg border bg-card text-card-foreground shadow-sm"
            >
                <ul class="divide-y divide-border">
                    <li
                        v-for="game in games"
                        :key="game.id"
                        class="flex items-center justify-between p-4 hover:bg-muted/50"
                    >
                        <div>
                            <span class="font-bold">{{ game.title }}</span>
                            <span class="ml-2 text-sm text-muted-foreground"
                                >({{ game.platform }})</span
                            >
                        </div>
                        <Link
                            :href="`/games/${game.id}`"
                            class="text-sm font-medium text-primary hover:text-primary/80 hover:underline"
                        >
                            Voir
                        </Link>
                    </li>
                </ul>
                <div
                    v-if="games.length === 0"
                    class="p-6 text-center text-muted-foreground"
                >
                    Aucun jeu pour le moment.
                </div>
            </div>
        </div>
    </AppLayout>
</template>
