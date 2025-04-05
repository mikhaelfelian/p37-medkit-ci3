<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Satusehat extends CI_Controller {

    /**
     * Satusehat controller.
     *
     * This controller handles integration with SATUSEHAT API from Kemenkes RI
     * for healthcare data exchange and interoperability.
     *
     * @author     Mikhael Felian Waskito <mikhaelfelian@gmail.com>
     * @copyright  2025-04-05
     * @github     mikhaelfelian
     */
    private string $url = 'https://api-satusehat.kemkes.go.id';
    private string $org_id = '100018572';
    private string $client_id = 'CeClLF3u1MJ06OpjirNOkPUWiPGBZmzIIyfP6IILYKVBDw7z';
    private string $client_secret = 'uvjqFLAEDm7XiijA1Zko8i9pfyMw7xVp8rpybeDTCQyvIoepfYFWiW0jFnbXpPso';
    
    // put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('Satusehat_model');
    }
    
    public function index(): void {
        $this->load->view('index');
    }

    public function generate_token(): string {
        $pengaturan     = $this->db->get('tbl_pengaturan')->row();
        $ss_org_id      = $pengaturan->ss_org_id;
        $ss_client_id   = $pengaturan->ss_client_id;
        $ss_client_scr  = $pengaturan->ss_client_secret;
        
        $curl = curl_init();
        $token = '';
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url . '/oauth2/v1/accesstoken?grant_type=client_credentials',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'client_id=' . $ss_client_id . '&client_secret=' . $ss_client_scr,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        $resArr = json_decode($response);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // echo "<pre>"; print_r($resArr); echo "</pre>";
            $data['token'] = $resArr->access_token;
            // echo $token;
        }

        return $data['token'];
        $this->load->view('index', $data);
    }

    public function get_ihsnumber_patient(string $nik): string {
        $pengaturan     = $this->db->get('tbl_pengaturan')->row();
        $ss_org_id      = $pengaturan->ss_org_id;
        $ss_client_id   = $pengaturan->ss_client_id;
        $ss_client_scr  = $pengaturan->ss_client_secret;
        
        $curl = curl_init();
        //$nik = '9271060312000001';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url . '/fhir-r4/v1/Patient?identifier=https%3A%2F%2Ffhir.kemkes.go.id%2Fid%2Fnik%7C' . $nik . '',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->generate_token() . ''
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $resArr = json_decode($response);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            //echo "<pre>"; print_r($resArr); echo "</pre>";
            if ($resArr->total == '0') {
                $data['ihsnumber'] = '';
                // echo "Gagal";
            } else {
                $data['ihsnumber'] = $resArr->entry[0]->resource->id;
                //echo "Berhasil";
            }

            //echo $idpractitioner;
        }
        return $data['ihsnumber'];
        //$this->load->view('index', $data);
    }

    public function get_idpractitioner(string $nik): string {
        $pengaturan     = $this->db->get('tbl_pengaturan')->row();
        $ss_org_id      = $pengaturan->ss_org_id;
        $ss_client_id   = $pengaturan->ss_client_id;
        $ss_client_scr  = $pengaturan->ss_client_secret;
        
        $curl = curl_init();
        //$nik = '7209061211900001';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url . '/fhir-r4/v1/Practitioner?identifier=https%3A%2F%2Ffhir.kemkes.go.id%2Fid%2Fnik%7C' . $nik . '',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->generate_token() . ''
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $resArr = json_decode($response);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            //echo "<pre>"; print_r($resArr); echo "</pre>";
            if ($resArr->total == '0') {
                $data['idpractitioner'] = '';
                // echo "Gagal";
            } else {
                $data['idpractitioner'] = $resArr->entry[0]->resource->id;
                //echo "Berhasil";
            }

            //echo $idpractitioner;
        }

        return $data['idpractitioner'];

        //$this->load->view('index', $data);
    }

    private function guidv4_1(?string $data = null): string {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = openssl_random_pseudo_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    private function guidv4_2(?string $data = null): string {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = openssl_random_pseudo_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function post_bundle_encounter_condition(): void {
        $pengaturan     = $this->db->get('tbl_pengaturan')->row();
        $ss_org_id      = $pengaturan->ss_org_id;
        $ss_client_id   = $pengaturan->ss_client_id;
        $ss_client_scr  = $pengaturan->ss_client_secret;
        
        $curl   = curl_init();
        $uuid1  = $this->guidv4_1();
        $uuid2  = $this->guidv4_2();
        //echo $this->Satusehat_model->total_rows();
        if ($this->Satusehat_model->total_rows() > 0) {
            $data = $this->Satusehat_model->get_data();
            foreach ($data as $row) {
                $postdata = '{
                        "resourceType": "Bundle",
                        "type": "transaction",
                        "entry": [
                            {
                                "fullUrl": "urn:uuid:' . $uuid1 . '",
                                "resource": {
                                    "resourceType": "Encounter",
                                    "status": "finished",
                                    "class": {
                                        "system": "http://terminology.hl7.org/CodeSystem/v3-ActCode",
                                        "code": "AMB",
                                        "display": "ambulatory"
                                    },
                                    "subject": {
                                        "reference": "Patient/' . $this->get_ihsnumber_patient($row->nik_pasien) . '",
                                        "display": "' . $row->nama_pasien . '"
                                    },
                                    "participant": [
                                        {
                                            "type": [
                                                {
                                                    "coding": [
                                                        {
                                                            "system": "http://terminology.hl7.org/CodeSystem/v3-ParticipationType",
                                                            "code": "ATND",
                                                            "display": "attender"
                                                        }
                                                    ]
                                                }
                                            ],
                                            "individual": {
                                                "reference": "Practitioner/' . $this->get_idpractitioner($row->nik_dokter) . '",
                                                "display": "' . $row->nama_dokter . '"
                                            }
                                        }
                                    ],
                                    "period": {
                                        "start": "' . date(DATE_ATOM, strtotime($row->waktu_kedatangan)) . '",
                                        "end": "' . date(DATE_ATOM, strtotime($row->waktu_selesai_periksa)) . '"
                                    },
                                    "location": [
                                        {
                                            "location": {
                                                "reference": "Location/' . $row->id_location . '",
                                                "display": "' . $row->nama_poliklinik . '"
                                            }
                                        }
                                    ],
                                    "diagnosis": [
                                        {
                                            "condition": {
                                                "reference": "urn:uuid:' . $uuid2 . '",
                                                "display": "' . $row->nama_diagnosa . '"
                                            },
                                            "use": {
                                                "coding": [
                                                    {
                                                        "system": "http://terminology.hl7.org/CodeSystem/diagnosis-role",
                                                        "code": "DD",
                                                        "display": "Discharge diagnosis"
                                                    }
                                                ]
                                            }
                                        }
                                    ],
                                    "statusHistory": [
                                        {
                                            "status": "arrived",
                                            "period": {
                                                "start": "' . date(DATE_ATOM, strtotime($row->waktu_kedatangan)) . '",
                                                "end": "' . date(DATE_ATOM, strtotime($row->waktu_periksa)) . '"
                                            }
                                        },
                                        {
                                            "status": "in-progress",
                                            "period": {
                                                "start": "' . date(DATE_ATOM, strtotime($row->waktu_periksa)) . '",
                                                "end": "' . date(DATE_ATOM, strtotime($row->waktu_selesai_periksa)) . '"
                                            }
                                        },
                                        {
                                            "status": "finished",
                                            "period": {
                                                "start": "' . date(DATE_ATOM, strtotime($row->waktu_selesai_periksa)) . '",
                                                "end": "' . date(DATE_ATOM, strtotime($row->waktu_selesai_periksa)) . '"
                                            }
                                        }
                                    ],
                                    "serviceProvider": {
                                        "reference": "Organization/' . $this->org_id . '" 
                                    },
                                    "identifier": [
                                        {
                                            "system": "http://sys-ids.kemkes.go.id/encounter/' . $this->org_id . '",
                                            "value": "' . $this->get_ihsnumber_patient($row->nik_pasien) . '"
                                        }
                                    ]
                                },
                                "request": {
                                    "method": "POST",
                                    "url": "Encounter"
                                }
                            },
                            {
                                "fullUrl": "urn:uuid:' . $uuid2 . '",
                                "resource": {
                                    "resourceType": "Condition",
                                    "clinicalStatus": {
                                        "coding": [
                                            {
                                                "system": "http://terminology.hl7.org/CodeSystem/condition-clinical",
                                                "code": "active",
                                                "display": "Active"
                                            }
                                        ]
                                    },
                                    "category": [
                                        {
                                            "coding": [
                                                {
                                                    "system": "http://terminology.hl7.org/CodeSystem/condition-category",
                                                    "code": "encounter-diagnosis",
                                                    "display": "Encounter Diagnosis"
                                                }
                                            ]
                                        }
                                    ],
                                    "code": {
                                        "coding": [
                                            {
                                                "system": "http://hl7.org/fhir/sid/icd-10",
                                                "code": "' . $row->kode_diagnosa . '",
                                                "display": "' . $row->nama_diagnosa . '"
                                            }
                                        ]
                                    },
                                    "subject": {
                                        "reference": "Patient/' . $this->get_ihsnumber_patient($row->nik_pasien) . '",
                                        "display": "' . $row->nama_pasien . '"
                                    },
                                    "encounter": {
                                        "reference": "urn:uuid:' . $uuid1 . '",
                                        "display": "Kunjungan Rawat Jalan Pasien ' . $row->nama_pasien . ' Tanggal ' . $row->waktu_kedatangan . '"
                                    }
                                },
                                "request": {
                                    "method": "POST",
                                    "url": "Condition"
                                }
                            }
                        ]
                    }';
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $this->url . '/fhir-r4/v1',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $postdata,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $this->generate_token() . ''
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                $resArr = json_decode($response);
                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    //echo "<pre>"; print_r($resArr); echo "</pre>";
                    if ($resArr->resourceType == 'OperationOutcome') {
                        $sql_cek = $this->db->where('id_medcheck', $row->id)->get('tbl_util_log_satusehat');
                        
                        $issue_data = $resArr->issue;
                        $serialized_data = json_encode($issue_data);
                        $data_log = array(
                            'id_medcheck' => $row->id,
                            'no_register' => $row->no_register,
                            'status' => 'ERROR-' . $resArr->resourceType,
                            'response_status' => $serialized_data,
                        );
                        
                        if($sql_cek->num_rows() == 0){
                            $this->Satusehat_model->insert_log($data_log);
                        }
                        echo "Gagal Kirim !";
                    } else {
                        $sql_log = $this->db->where('id_medcheck', $row->id)->get('tbl_util_log_satusehat');
                        
                        $data = array(
                            'id_encounter' => $resArr->entry[0]->response->resourceID,
                            'id_condition' => $resArr->entry[1]->response->resourceID,
                        );

                        //echo "<pre>"; print_r($resArr->entry[0]->response->resourceID); echo "</pre>";

//                        $this->Satusehat_model->update_id($row->id, $data);
                        $this->db->where('id', $row->id)->update('tbl_trans_medcheck', $data);

                        $data_log = array(
                            'id_medcheck' => $row->id,
                            'no_register' => $row->no_register,
                            'status' => 'SUCCESS-' . $resArr->resourceType,
                            'response_status' => $resArr->entry[0]->response->status,
                        );
                        
                        if($sql_log->num_rows() == 0){
                            $this->Satusehat_model->insert_log($data_log);
                        }

                        echo "Sukses Kirim !";
                    }
                }
            }
        } else {
            echo "Belum Ada Data Untuk Dikirim !";
        }
    }

}
