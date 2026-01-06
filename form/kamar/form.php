<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-plus-circle"></i> Tambah Kamar Baru
                </h3>
            </div>
            <form action="form/kamar/simpan.php" method="POST" id="formKamar">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipe_kamar">Tipe Kamar *</label>
                                <select class="form-control select2" id="tipe_kamar" name="tipe_kamar" required>
                                    <option value="">-- Pilih Tipe Kamar --</option>
                                    <option value="Standard">Standard</option>
                                    <option value="Deluxe">Deluxe</option>
                                    <option value="Superior">Superior</option>
                                    <option value="Executive Suite">Executive Suite</option>
                                    <option value="Family Room">Family Room</option>
                                    <option value="Ekonomi">Ekonomi</option>
                                    <option value="Bisnis">Bisnis</option>
                                    <option value="VIP">VIP</option>
                                    <option value="Presidential Suite">Presidential Suite</option>
                                    <option value="Honeymoon Suite">Honeymoon Suite</option>
                                </select>
                                <small class="text-muted">Pilih tipe kamar yang tersedia atau ketik custom</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga">Harga per Malam (Rp) *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" class="form-control" id="harga" name="harga" 
                                           placeholder="Masukkan harga kamar" required min="0"
                                           oninput="formatHarga(this)">
                                </div>
                                <small class="text-muted">Harga dalam Rupiah per malam</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status Kamar *</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="tersedia">Tersedia</option>
                                    <option value="terisi">Terisi</option>
                                    <option value="dibersihkan">Dibersihkan</option>
                                    <option value="maintenance">Maintenance</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nomor_kamar">Nomor Kamar (Opsional)</label>
                                <input type="text" class="form-control" id="nomor_kamar" name="nomor_kamar" 
                                       placeholder="Contoh: 101, 201, A1, B2">
                                <small class="text-muted">Jika kosong, akan dibuat otomatis</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Fasilitas Kamar -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Fasilitas Kamar</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="fasilitas[]" value="AC" id="fasilitas_ac" checked>
                                            <label class="form-check-label" for="fasilitas_ac">
                                                <i class="fas fa-snowflake"></i> AC
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="fasilitas[]" value="TV" id="fasilitas_tv" checked>
                                            <label class="form-check-label" for="fasilitas_tv">
                                                <i class="fas fa-tv"></i> TV
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="fasilitas[]" value="WiFi" id="fasilitas_wifi" checked>
                                            <label class="form-check-label" for="fasilitas_wifi">
                                                <i class="fas fa-wifi"></i> WiFi
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="fasilitas[]" value="Kamar Mandi" id="fasilitas_km" checked>
                                            <label class="form-check-label" for="fasilitas_km">
                                                <i class="fas fa-bath"></i> Kamar Mandi
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="fasilitas[]" value="Mini Bar" id="fasilitas_minibar">
                                            <label class="form-check-label" for="fasilitas_minibar">
                                                <i class="fas fa-wine-bottle"></i> Mini Bar
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="fasilitas[]" value="Bathtub" id="fasilitas_bathtub">
                                            <label class="form-check-label" for="fasilitas_bathtub">
                                                <i class="fas fa-hot-tub"></i> Bathtub
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="fasilitas[]" value="Balkon" id="fasilitas_balkon">
                                            <label class="form-check-label" for="fasilitas_balkon">
                                                <i class="fas fa-door-open"></i> Balkon
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="fasilitas[]" value="Kitchenette" id="fasilitas_kitchen">
                                            <label class="form-check-label" for="fasilitas_kitchen">
                                                <i class="fas fa-utensils"></i> Kitchenette
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <textarea class="form-control" name="fasilitas_lainnya" 
                                                  placeholder="Fasilitas lainnya (opsional)" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Informasi Tambahan -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="luas_kamar">Luas Kamar (m²)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="luas_kamar" name="luas_kamar" 
                                           placeholder="Contoh: 24, 32, 40" min="10" max="200">
                                    <div class="input-group-append">
                                        <span class="input-group-text">m²</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kapasitas">Kapasitas Maksimal</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="kapasitas" name="kapasitas" 
                                           placeholder="Contoh: 2, 4, 6" min="1" max="10" value="2">
                                    <div class="input-group-append">
                                        <span class="input-group-text">orang</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="keterangan">Keterangan Tambahan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" 
                                          rows="3" placeholder="Keterangan tambahan tentang kamar (opsional)"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Preview Harga -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <h5><i class="fas fa-info-circle"></i> Informasi Kamar</h5>
                                <div id="previewInfo">
                                    <p>Silahkan isi form di atas untuk melihat preview informasi kamar.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Kamar
                    </button>
                    <a href="dashboard.php?menu=kamar" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="button" class="btn btn-info" onclick="updatePreview()">
                        <i class="fas fa-eye"></i> Preview
                   