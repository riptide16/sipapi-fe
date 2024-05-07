<?php

namespace App;

use Carbon\Carbon;

class Helpers
{
    public static function routeList()
    {
        return [
            'admin.dashboard',
            'admin.user.index',
            'admin.user.create',
            'admin.user.edit',
            'admin.user.show',
            'admin.role.index',
            'admin.role.create',
            'admin.role.edit',
            'admin.access.index',
            'admin.data_kelembagaan.index',
            'admin.data_kelembagaan.show',
            'admin.data_kelembagaan.edit',
            'admin.data_kelembagaan.verify',
            'admin.instrumen.index',
            'admin.instrumen.create',
            'admin.instrumen.edit',
            'admin.instrumen.show',
            'admin.instrumen.first_sub_components.create',
            'admin.instrumen.first_sub_components.edit',
            'admin.instrumen.first_sub_components.show',
            'admin.instrumen.second_sub_components.create',
            'admin.instrumen.second_sub_components.edit',
            'admin.instrumen.second_sub_components.show',
            'admin.master_data.index',
            'admin.master_data.provinces.index',
            'admin.master_data.provinces.create',
            'admin.master_data.provinces.edit',
            'admin.master_data.provinces.show',
            'admin.master_data.cities.index',
            'admin.master_data.cities.create',
            'admin.master_data.cities.edit',
            'admin.master_data.cities.show',
            'admin.master_data.subdistricts.index',
            'admin.master_data.subdistricts.create',
            'admin.master_data.subdistricts.edit',
            'admin.master_data.subdistricts.show',
            'admin.master_data.villages.index',
            'admin.master_data.villages.create',
            'admin.master_data.villages.edit',
            'admin.master_data.regions.index',
            'admin.master_data.regions.create',
            'admin.master_data.regions.edit',
            'admin.master_data.regions.show',
            'admin.berita.index',
            'admin.berita.create',
            'admin.berita.edit',
            'admin.berita.show',
            'admin.master_data.villages.show',
            'admin.access.edit',
            'admin.access.show',
            'admin.banner.index',
            'admin.banner.create',
            'admin.banner.edit',
            'admin.banner.show',
            'admin.galeri.index',
            'admin.galeri.create',
            'admin.galeri.edit',
            'admin.galeri.show',
            'admin.video.index',
            'admin.video.create',
            'admin.video.edit',
            'admin.video.show',
            'admin.testimoni.index',
            'admin.testimoni.create',
            'admin.testimoni.edit',
            'admin.testimoni.show',
            'admin.email-template.index',
            'admin.email-template.edit',
            'admin.email-template.show',
            'admin.faq.index',
            'admin.faq.create',
            'admin.faq.edit',
            'admin.faq.show',
            'admin.wilayah.index',
            'admin.wilayah.create',
            'admin.wilayah.edit',
            'admin.wilayah.show',
            'admin.akreditasi.index',
            'admin.akreditasi.create',
            'admin.akreditasi.edit',
            'admin.akreditasi.show',
            'admin.akreditasi.verify',
            'admin.akreditasi.file_download',
            'admin.instrumen.index',
            'admin.instrumen.create',
            'admin.instrumen.edit',
            'admin.instrumen.show',
            'admin.instrumen.aspects.index',
            'admin.instrumen.aspects.create',
            'admin.instrumen.aspects.edit',
            'admin.instrumen.aspects.show',
            'admin.kategori_instrumen.index',
            'admin.kategori_instrumen.create',
            'admin.kategori_instrumen.edit',
            'admin.kategori_instrumen.show',
            'admin.akreditasi.results',
            'admin.akreditasi.process',
            'admin.notification.index',
            'admin.notification.show',
            'admin.file-download.index',
            'admin.file-download.create',
            'admin.file-download.edit',
            'admin.file-download.show',
            'admin.log.index',
            'admin.log.show',
            'admin.penilaian.index',
            'admin.penilaian.show',
            'admin.penilaian.results',
            'admin.penilaian.evaluate',
            'admin.penilaian.recap',
            'admin.penilaian.file_download',
	    'admin.penilaian.show_institution',
            'admin.penilaian.export_onthespot',
            'admin.sertifikasi.index',
            'admin.sertifikasi.edit',
            'admin.profile',
            'admin.akreditasi.accept',
            'admin.content-website.public-menu.index',
            'admin.content-website.public-menu.create',
            'admin.content-website.public-menu.show',
            'admin.content-website.public-menu.edit',
            'admin.content-website.page.index',
            'admin.content-website.page.create',
            'admin.content-website.page.show',
            'admin.content-website.page.edit',
            'admin.report.index',
            'admin.report.library_type.in_year.detail_type_year',
            'admin.report.province.index',
            'admin.report.library_type.by_year',
            'admin.report.library_type.in_year.index',
            'admin.report.province.in_year',
            'admin.report.library_type.latest',
            'admin.report.library_type.terakreditasi_in_year.index',
            'admin.report.library_type.terakreditasi_in_year.show',
            'admin.report.total',
            'admin.report.province.terakreditasi.index',
            'admin.report.province.terakreditasi.show',
            'admin.report.province.terakreditasi.by_year',
            'admin.report.library_type.terakreditasi_in_year.by_year',
            'admin.self-assessment.create',
            'admin.self-assessment.results',
            'admin.self-assessment.store',
        ];
    }

    public static function isAsesi()
    {
        if (!$user = session('user')) {
            return false;
        }

        return $user['data']['role']['name'] === 'asesi';
    }

    public static function isAsesor()
    {
        if (!$user = session('user')) {
            return false;
        }

        return $user['data']['role']['name'] === 'asesor';
    }

    public static function formatDate($date, $format = 'Y-m-d H:i:s')
    {
        $date = Carbon::parse($date)->locale('id_ID')->setTimezone('Asia/Jakarta');
        return $date->translatedFormat($format);
    }

    public static function titlize($string)
    {
        return \Str::title(\Str::replace('_', ' ', $string));
    }

    public static function isAdmin()
    {
        if (!$user = session('user')) {
            return false;
        }

        return $user['data']['role']['name'] === 'super_admin';
    }

    public static function isProvince()
    {
        if (!$user = session('user')) {
            return false;
        }

        return $user['data']['role']['name'] === 'provinsi';
    }
}
