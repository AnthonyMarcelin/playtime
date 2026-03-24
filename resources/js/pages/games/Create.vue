<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';

const form = useForm({
    title: '',
    cover_url: '',
    platform: '',
    genre: '',
});

const submit = () => {
    form.post('/games');
};
</script>

<template>
    <AppLayout>
        <Head title="Ajouter un jeu" />

        <div class="mx-auto max-w-2xl py-10 sm:px-6 lg:px-8">
            <div class="mb-6">
                <Heading
                    title="Ajouter un jeu"
                    description="Ajoutez un nouveau jeu à votre bibliothèque."
                />
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div class="space-y-2">
                    <Label for="title">Titre du jeu</Label>
                    <Input
                        id="title"
                        v-model="form.title"
                        type="text"
                        autofocus
                    />
                    <InputError :message="form.errors.title" />
                </div>

                <div class="space-y-2">
                    <Label for="cover_url">URL de la couverture</Label>
                    <Input id="cover_url" v-model="form.cover_url" type="url" />
                    <InputError :message="form.errors.cover_url" />
                </div>

                <div class="space-y-2">
                    <Label for="platform">Plateforme</Label>
                    <Input id="platform" v-model="form.platform" type="text" />
                    <InputError :message="form.errors.platform" />
                </div>

                <div class="space-y-2">
                    <Label for="genre">Genre</Label>
                    <Input id="genre" v-model="form.genre" type="text" />
                    <InputError :message="form.errors.genre" />
                </div>

                <div class="flex justify-end pt-4">
                    <Button type="submit" :disabled="form.processing">
                        Enregistrer
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
