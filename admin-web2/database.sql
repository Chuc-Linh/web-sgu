use web2;
set names 'utf8mb4';

-- 1. Bảng loai
CREATE TABLE loai(
    maloai varchar(20) primary key not null,
    tenloai varchar(20) not null unique,
    mota varchar(225) not null
);
INSERT INTO loai (maloai, tenloai, mota) VALUES 
('Jean', 'Balo Jean', 'Cac balo đeo chất liệu bằng Jean'),
('Bạt', 'Balo Bạt', 'Cac balo đeo chất liệu bằng tấm Bạt'),
('Tote', 'Giỏ Tote Bạt', 'Cac giỏ tote chất liệu bằng tấm Bạt'),
('Đeo', 'Túi Đeo Bạt', 'Cac túi đeo chất liệu bằng tấm Bạt'),
('Tất', 'Tất Nhựa', 'Cac đôi tất được làm từ vải nhựa');

-- 2. Bảng sanpham
CREATE TABLE sanpham(
    masp int auto_increment primary key not null,
    tensp varchar(225) not null,
    hientrang varchar(20) not null,
    donvitinh varchar(20) not null,
    phantramloinhuanmongmuon float not null check(phantramloinhuanmongmuon > 0),
    giabandexuat float not null check(giabandexuat > 0),
    maloai varchar(20),
    foreign key (maloai) references loai(maloai)
);

-- Sửa INSERT: Bỏ dấu nháy ở các trường số (float, int)
INSERT INTO sanpham (tensp, hientrang, donvitinh, giabandexuat, phantramloinhuanmongmuon, maloai) VALUES 
('Báo Hồng', 'Hiển Thị', 'Chiếc', 2500000, 15.5, 'Bạt'),
('Đồ Ngọt', 'Hiển Thị', 'Chiếc', 2500000, 15.5, 'Bạt'),
('Tia Cực Tím', 'Hiển Thị', 'Chiếc', 2500000, 15.5, 'Bạt'),
('Trơn Tru Trắng', 'Hiển Thị', 'Chiếc', 2500000, 15.5, 'Bạt'),
('Mất Màu', 'Ẩn', 'Chiếc', 4000000, 20.0, 'Jean'),
('Em Xinh', 'Hiển Thị', 'Chiếc', 4000000, 20.0, 'Jean'),
('Thế Giới', 'Hiển Thị', 'Chiếc', 4000000, 20.0, 'Jean'),
('Chia Đất', 'Hiển Thị', 'Chiếc', 4000000, 20.0, 'Jean'),
('Bày Mẹo Tốt', 'Hiển Thị', 'Chiếc', 5000000, 10.0, 'Tote'),
('Thìn King', 'Hiển Thị', 'Chiếc', 5000000, 10.0, 'Tote'),
('Chợ Phiên', 'Hiển Thị', 'Chiếc', 5000000, 10.0, 'Tote'),
('Tốt Dần', 'Hiển Thị', 'Chiếc', 5000000, 10.0, 'Tote'),
('Đông Xuân', 'Hiển Thị', 'Chiếc', 5000000, 10.0, 'Đeo'),
('Hồng Hạc', 'Hiển Thị', 'Chiếc', 5000000, 10.0, 'Đeo'),
('Cà Phê', 'Hiển Thị', 'Chiếc', 5000000, 10.0, 'Đeo'),
('Âm nhạc', 'Hiển Thị', 'Chiếc', 5000000, 10.0, 'Đeo'),
('Ô Ăn Quan', 'Hiển Thị', 'Đôi', 1000000, 10.0, 'Tất'),
('Kéo Búa Bao', 'Hiển Thị', 'Đôi', 1000000, 10.0, 'Tất'),
('Lúa Nước Việt Nam', 'Hiển Thị', 'Đôi', 1000000, 10.0, 'Tất'),
('Đen Thui', 'Hiển Thị', 'Đôi', 1000000, 10.0, 'Tất');

-- 3. Bảng khachhang
CREATE TABLE khachhang(
    username varchar(50) primary key not null,
    hoten varchar(50) not null,
    trangthaitk varchar(20) not null,
    SDT varchar (10) not null,
    diachinha varchar(225) not null,
    phuong varchar(255) not null,
    thanhpho varchar(255) not null,
    matkhau varchar(225) not null
);
INSERT INTO khachhang (username, hoten, matkhau, sdt, trangthaitk, diachinha, phuong, thanhpho) VALUES 
('nguyenvan', 'Hoàng Văn Hà','pa$$w0rd123', '0912345671', 'Hoạt động', 'Số 15, Ngõ 2', ' Dịch Vọng',  'Hà Nội'),
('lethib','Nguyễn Văn Kiện', 'secret2024', '0988777662', 'Hoạt động', '452 Lê Lợi', ' 7', 'TP. Hồ Chí Minh'),
('tranvanc','Nguyễn Bá Khang'
,'hallo@2026', '0905123453', 'Bị khóa', 'K12/45 Hoàng Diệu', ' Phước Ninh',  'Đà Nẵng'),
('phamthid', 'Lâm Duy Chúc Linh','flower99', '0944111224', 'Hoạt động', '78 Hùng Vương', 'Lộc Thọ', 'Khánh Hòa'),
('hoangvane','Trần Văn Minh', 'dragon_king', '0933555665', 'Hoạt động', 'Đường 30/4', 'Xuân Khánh', 'Cần Thơ'),
('nguyenvana', 'Nguyễn Văn A', 'Hoạt động', '0901234567', '123 Lê Lợi', 'Bến Nghé', 'Hồ Chí Minh', 'pw12345'),
('tran thịb', 'Trần Thị B', 'Hoạt động', '0912345678', '456 Nguyễn Huệ', '1', 'Đà Lạt', 'pass2024'),
('le_van_c', 'Lê Văn C', 'Bị khóa', '0987654321', '789 Trần Hưng Đạo', 'An Hải Bắc', 'Đà Nẵng', 'secret789'),
('pham_thi_d', 'Phạm Thị D', 'Hoạt động', '0345678901', '101 Hai Bà Trưng', '5', 'Vũng Tàu', 'd_pham_123'),
('hoang_anh_e', 'Hoàng Văn E', 'Hoạt động', '0765432109', '202 Lý Tự Trọng', 'Thạch Thang', 'Đà Nẵng', 'anh_e_secure'),
('ngo_thi_f', 'Ngô Thị F', 'Bị khóa', '0933445566', '303 Phan Chu Trinh', 'Vạn Thạnh', 'Nha Trang', 'f_ngo_2026'),
('vu_van_g', 'Vũ Văn G', 'Hoạt động', '0944556677', '404 Cách Mạng Tháng 8', '10', 'Hồ Chí Minh', 'vuvang11'),
('dang_thi_h', 'Đặng Thị H', 'Hoạt động', '0955667788', '505 Kim Mã', 'Ngọc Khánh', 'Hà Nội', 'dangh_pw'),
('bui_van_i', 'Bùi Văn I', 'Hoạt động', '0966778899', '606 Láng Hạ', 'Thành Công', 'Hà Nội', 'buivan_i9'),
('ly_thi_k', 'Lý Thị K', 'Bị khóa', '0977889900', '707 Trần Phú', '5', 'Cần Thơ', 'lythi_k_pass'),
('do_van_l', 'Đỗ Văn L', 'Hoạt động', '0922334455', '808 Hùng Vương', ' 1', 'Huế', 'dovanl_2026'),
('truong_thi_m', 'Trương Thị M', 'Hoạt động', '0811223344', '909 Nguyễn Văn Linh', 'Tân Phong', 'Hồ Chí Minh', 'm_truong_xyz'),
('phan_van_n', 'Phan Văn N', 'Hoạt động', '0822334455', '111 Bà Triệu', 'Lê Đại Hành', 'Hà Nội', 'phann_123'),
('trinh_thi_o', 'Trịnh Thị O', 'Bị khóa', '0833445566', '222 Lê Duẩn', 'Thạch Thang', 'Đà Nẵng', 'trinho_secure'),
('duong_van_p', 'Dương Văn P', 'Hoạt động', '0844556677', '333 Võ Văn Kiệt', 'Cô Giang', 'Hồ Chí Minh', 'duongp_456');

-- 4. Bảng hoadon
CREATE TABLE hoadon (
    mahd VARCHAR(20) PRIMARY KEY NOT NULL,
    ngaydat DATE DEFAULT (CURRENT_DATE), 
    phuongthucthanhtoan VARCHAR(50) NOT NULL,
    trangthai VARCHAR(50) NOT NULL,
    diachihd VARCHAR(255) NOT NULL, 
    phuonghd VARCHAR(255) NOT NULL,
    thanhphohd VARCHAR(255) NOT NULL,
    username VARCHAR(50), 
    FOREIGN KEY (username) REFERENCES khachhang(username)
);
INSERT INTO hoadon (mahd, ngaydat, phuongthucthanhtoan, trangthai, diachihd, phuonghd, thanhphohd, username) VALUES 
('HD01', '2023-10-10', 'Chuyen khoan', 'Cho xu ly', '452 Lê Lợi', 'Phường 7', 'TP. Hồ Chí Minh', 'nguyenvana'),
('HD02', '2023-10-11', 'Chuyen khoan', 'Dang giao', '105 Bà Huyện Thanh Quan','Phường Võ Thị Sáu','TP. Hồ Chí Minh', 'lethib'),
('HD03', '2026-01-15', 'Tien mat', 'Dang giao', '78 Hùng Vương', 'Lộc Thọ', 'Khánh Hòa', 'phamthid'),
('HD04', '2026-01-16', 'Chuyen khoan', 'Dang giao', 'Đường 30/4', 'Xuân Khánh', 'Cần Thơ', 'hoangvane'),
('HD05', '2026-03-18', 'Tien mat', 'Da huy', '456 Nguyễn Huệ', '1', 'Đà Lạt', 'tran thịb'),
('HD06', '2026-04-20', 'Chuyen khoan', 'Da giao', '101 Hai Bà Trưng', '5', 'Vũng Tàu', 'pham_thi_d'),
('HD07', '2026-05-21', 'Tien mat', 'Dang giao', '404 Cách Mạng Tháng 8', '10', 'Hồ Chí Minh', 'vu_van_g'),
('HD08', '2026-06-22', 'Chuyen khoan', 'Da giao', '505 Kim Mã', 'Ngọc Khánh', 'Hà Nội', 'dang_thi_h'),
('HD09', '2026-07-23', 'Chuyen khoan', 'Dang giao', '606 Láng Hạ', 'Thành Công', 'Hà Nội', 'bui_van_i'),
('HD10', '2026-08-24', 'Tien mat', 'Dang giao', '808 Hùng Vương', '1', 'Huế', 'do_van_l'),
('HD11', '2026-09-25', 'Chuyen khoan', 'Da giao', '909 Nguyễn Văn Linh', 'Tân Phong', 'Hồ Chí Minh', 'truong_thi_m'),
('HD12', '2026-10-26', 'Chuyen khoan', 'Da giao', '111 Bà Triệu', 'Lê Đại Hành', 'Hà Nội', 'phan_van_n'),
('HD13', '2026-11-27', 'Tien mat', 'Da giao', '333 Võ Văn Kiệt', 'Cô Giang', 'Hồ Chí Minh', 'duong_van_p'),
('HD14', '2026-12-28', 'Chuyen khoan', 'Da huy', '202 Lý Tự Trọng', 'Thạch Thang', 'Đà Nẵng', 'hoang_anh_e'),
('HD15', '2027-01-29', 'Chuyen khoan', 'Da giao', 'Số 15, Ngõ 2', 'Dịch Vọng', 'Hà Nội', 'nguyenvana');

-- 5. Bảng chitiethd
CREATE TABLE chitiethd (
    macthd VARCHAR(20) PRIMARY KEY NOT NULL,
    giaban FLOAT NOT NULL CHECK (giaban > 0), 
    soluongmua INT NOT NULL CHECK (soluongmua > 0),
    Thanhtien FLOAT GENERATED ALWAYS AS (giaban * soluongmua) STORED,
    masp int not null,
    mahd varchar(20),
    FOREIGN KEY (masp) REFERENCES sanpham(masp),
    foreign key(mahd) references hoadon(mahd)
);
-- Sửa INSERT: Thêm masp và bỏ dấu nháy cho các số
INSERT INTO chitiethd (macthd, giaban, soluongmua, masp, mahd) VALUES 
('CTHD01', 2800000, 1, 1, 'HD01'),
('CTHD02', 800000, 20, 17, 'HD01'),
('CTHD03', 2500000, 1, 3, 'HD02'), -- Tia Cực Tím
('CTHD04', 4000000, 3, 6, 'HD03'), -- Em Xinh
('CTHD05', 5000000, 1, 9, 'HD04'), -- Bày Mẹo Tốt
('CTHD06', 5000000, 2, 13, 'HD05'), -- Đông Xuân
('CTHD07', 1000000, 5, 17, 'HD06'), -- Ô Ăn Quan
('CTHD08', 2500000, 2, 4, 'HD07'), -- Trơn Tru Trắng
('CTHD09', 4000000, 1, 7, 'HD10'), -- Thế Giới
('CTHD10', 5000000, 1, 10, 'HD11'), -- Thìn King
('CTHD11', 1000000, 10, 20, 'HD12'), -- Đen Thui
('CTHD12', 5000000, 2, 15, 'HD13'), -- Cà Phê
('CTHD13', 4000000, 1, 8, 'HD14'), -- Chia Đất
('CTHD14', 5000000, 1, 14, 'HD15'), -- Hồng Hạc
('CTHD15', 1000000, 4, 18, 'HD15'); -- Kéo Búa Bao

-- 6. Bảng nhacungcap
CREATE TABLE nhacungcap(
    maNCC varchar(20) primary key not null,
    tenNCC varchar(225) not  null
);
INSERT INTO nhacungcap (maNCC, tenNCC) VALUES 
('NCC01', 'Cong ty TNHH Apple Viet Nam'),
('NCC02', 'Nha phan phoi Digiworld'),
('NCC03', 'Samsung Electronics');

-- 7. Bảng phieunhap
CREATE TABLE phieunhap(
    maphieunhap varchar(20) primary key not null,
    ngaynhap date default (current_date),
    maNCC varchar(20),
    foreign key(maNCC) references nhacungcap(maNCC)
);
INSERT INTO phieunhap (maphieunhap, ngaynhap, maNCC) VALUES 
('PN01', '2023-10-01', 'NCC01'),
('PN02', '2023-10-05', 'NCC02'),
('PN03', '2023-11-10', 'NCC03'),
('PN04', '2023-12-15', 'NCC01'),
('PN05', '2024-01-20', 'NCC02'),
('PN06', '2024-02-14', 'NCC03'),
('PN07', '2024-03-05', 'NCC01'),
('PN08', '2024-04-12', 'NCC02'),
('PN09', '2024-05-25', 'NCC03'),
('PN10', '2024-06-30', 'NCC01'),
('PN11', '2024-07-08', 'NCC02'),
('PN12', '2024-08-19', 'NCC03'),
('PN13', '2024-09-22', 'NCC01'),
('PN14', '2024-10-05', 'NCC02'),
('PN15', '2024-11-11', 'NCC03');

-- 8. Bảng chitietphieunhap
CREATE TABLE chitietphieunhap(
    mactpn varchar(20) primary key not null,
    gianhap float not null check(gianhap>0),
    soluongnhap int not null check(soluongnhap>0),
    tongtien float generated always as(gianhap*soluongnhap) stored,
    masp int not null,
    maphieunhap varchar(20),
    foreign key (masp) references sanpham(masp),
    foreign key (maphieunhap) references phieunhap(maphieunhap)
);

INSERT INTO chitietphieunhap (mactpn, gianhap, soluongnhap, masp, maphieunhap) VALUES 
('CTPN01', 2000000, 10, 1, 'PN01'),
('CTPN02', 3500000, 5, 2, 'PN02'),
('CTPN03', 2000000, 20, 3, 'PN03'), -- Tia Cực Tím
('CTPN04', 3000000, 15, 6, 'PN04'), -- Em Xinh
('CTPN05', 3800000, 10, 9, 'PN05'), -- Bày Mẹo Tốt
('CTPN06', 3800000, 12, 13, 'PN06'), -- Đông Xuân
('CTPN07', 800000, 50, 17, 'PN07'), -- Ô Ăn Quan
('CTPN08', 2000000, 25, 4, 'PN08'), -- Trơn Tru Trắng
('CTPN09', 3000000, 10, 7, 'PN09'), -- Thế Giới
('CTPN10', 3800000, 15, 10, 'PN10'), -- Thìn King
('CTPN11', 800000, 40, 20, 'PN11'), -- Đen Thui
('CTPN12', 3800000, 20, 15, 'PN12'), -- Cà Phê
('CTPN13', 3000000, 15, 8, 'PN13'), -- Chia Đất
('CTPN14', 3800000, 10, 14, 'PN14'), -- Hồng Hạc
('CTPN15', 800000, 30, 18, 'PN15'); -- Kéo Búa Bao