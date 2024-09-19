<template>
  <div>
    <!-- Tabel Tiket -->
    <div class="card mb-10">
      <div class="card-header">
        <h2 class="mb-10 mt-10">Daftar Tiket</h2>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Judul</th>
              <th>Deskripsi</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="tiket in tiketList" :key="tiket.id">
              <td>{{ tiket.judul }}</td>
              <td>{{ tiket.deskripsi }}</td>
              <td>{{ tiket.status }}</td>
              <td>
                <button class="btn btn-primary me-2" style="width: 50px; height: 50px; padding: 0; text-align: center; line-height: 50px;" @click="editTiket(tiket)">
                  <i class="la la-pencil" style="font-size: 20px"></i>                 
                </button>

                <button class="btn btn-danger" style="width: 50px; height: 50px; padding: 0; text-align: center; line-height: 50px;" @click="deleteTiket(tiket.id)">
                  <i class="la la-trash" style="font-size: 20px"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Form Create/Edit Tiket -->
    <VForm class="card mb-10" @submit="submit" :validation-schema="formSchema">
      <div class="card-header align-items-center">
        <h2 class="mb-0">
          {{ isEditMode ? "Edit Tiket" : "Buat Tiket Baru" }}
        </h2>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <!-- Input Judul -->
            <div class="fv-row mb-8">
              <label class="form-label fw-bold fs-6 required"
                >Judul Tiket</label
              >
              <Field
                class="form-control form-control-lg form-control-solid"
                type="text"
                name="judul"
                autocomplete="off"
                v-model="formData.judul"
              />
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="judul" />
                </div>
              </div>
            </div>

            <!-- Input Deskripsi -->
            <div class="fv-row mb-8">
              <label class="form-label fw-bold fs-6 required">Deskripsi</label>
              <Field
                class="form-control form-control-lg form-control-solid"
                type="textarea"
                name="deskripsi"
                autocomplete="off"
                v-model="formData.deskripsi"
              />
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="deskripsi" />
                </div>
              </div>
            </div>

            <!-- Input Status -->
            <div class="fv-row mb-8">
              <label class="form-label fw-bold fs-6 required">Status</label>
              <Field
                class="form-control form-control-lg form-control-solid"
                as="select"
                name="status"
                autocomplete="off"
                v-model="formData.status"
              >
                <option value="open">Open</option>
                <option value="in_progress">In Progress</option>
                <option value="closed">Closed</option>
              </Field>
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="status" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer d-flex">
        <button type="submit" class="btn btn-primary btn-sm ms-auto">
          {{ isEditMode ? "Update Tiket" : "Simpan Tiket" }}
        </button>
      </div>
    </VForm>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import * as Yup from "yup";
import axios from '@/libs/axios';
import { toast } from "vue3-toastify";

export default defineComponent({
  setup() {
    const tiketList = ref([
      // Data tiket dummy untuk contoh
      {
        id: 1,
        judul: "Tiket 1",
        deskripsi: "Deskripsi Tiket 1",
        status: "open",
      },
      {
        id: 2,
        judul: "Tiket 2",
        deskripsi: "Deskripsi Tiket 2",
        status: "in_progress",
      },
    ]);

    const isEditMode = ref(false);
    const formData = ref({
      judul: "",
      deskripsi: "",
      status: "open",
    });

    const formSchema = Yup.object().shape({
      judul: Yup.string().required("Judul wajib diisi"),
      deskripsi: Yup.string().required("Deskripsi wajib diisi"),
      status: Yup.string().required("Status wajib dipilih"),
    });

    const submit = () => {
      if (isEditMode.value) {
        // Jika mode edit, update tiket
        const tiketIndex = tiketList.value.findIndex(
          (tiket) => tiket.id === formData.value.id
        );
        tiketList.value[tiketIndex] = { ...formData.value };
        toast.success("Tiket berhasil diupdate");
      } else {
        // Jika mode create, tambahkan tiket baru
        tiketList.value.push({
          ...formData.value,
          id: tiketList.value.length + 1,
        });
        toast.success("Tiket berhasil dibuat");
      }
      resetForm();
    };

    const resetForm = () => {
      formData.value = {
        judul: "",
        deskripsi: "",
        status: "open",
      };
      isEditMode.value = false;
    };

    const editTiket = (tiket) => {
      formData.value = { ...tiket };
      isEditMode.value = true;
    };

    const deleteTiket = (id) => {
      tiketList.value = tiketList.value.filter((tiket) => tiket.id !== id);
      toast.success("Tiket berhasil dihapus");
    };

    return {
      tiketList,
      formData,
      formSchema,
      submit,
      isEditMode,
      editTiket,
      deleteTiket,
    };
  },
});
</script>
