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
('nguyenvana', 'Hoàng Văn Hà','pa$$w0rd123', '0912345671', 'Hoạt động', 'Số 15, Ngõ 2', 'Phường Dịch Vọng',  'Hà Nội'),
('lethib','Nguyễn Văn Kiện', 'secret2024', '0988777662', 'Hoạt động', '452 Lê Lợi', 'Phường 7', 'TP. Hồ Chí Minh'),
('tranvanc','Nguyễn Bá Khang'
,'hallo@2026', '0905123453', 'Bị khóa', 'K12/45 Hoàng Diệu', 'Phường Phước Ninh',  'Đà Nẵng'),
('phamthid', 'Lâm Duy Chúc Linh','flower99', '0944111224', 'Hoạt động', '78 Hùng Vương', 'Phường Lộc Thọ', 'Khánh Hòa'),
('hoangvane','Trần Văn Minh', 'dragon_king', '0933555665', 'Hoạt động', 'Đường 30/4', 'Phường Xuân Khánh', 'Cần Thơ');

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
('HD01', '2023-10-10', 'Chuyen khoan', 'Da giao', '452 Lê Lợi', 'Phường 7', 'TP. Hồ Chí Minh', 'nguyenvana'),
('HD02', '2023-10-11', 'Tien mat', 'Dang giao', '105 Bà Huyện Thanh Quan','Phường Võ Thị Sáu','TP. Hồ Chí Minh', 'lethib');

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
('CTHD03', 4500000, 2, 5, 'HD02');

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
('PN02', '2023-10-05', 'NCC02');

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
('CTPN02', 3500000, 5, 2, 'PN02');