    <?php
        require('fpdf.php');
        include('Connexion_BDD.php');
        include('Chiffres.php');
        
        class PDF extends FPDF
        {
            // En-tête
            function Header()
            {
                // Police Arial gras 15
                $this->SetFont('Arial', '',6);
                $this->Cell(20,2, "Ministre de l'interieur des collectivites locales");
                $this->Cell(20,2,$this->Cell(60) . $this->SetFont('Arial', '',9) . "REPUBLIQUE ALGERIENNE DEMOCRATIQUE ET POPULAIRE");
                $this->Ln(3);
                $this->SetFont('Arial', '',6);
                $this->Cell(20,2,utf8_decode("Et de l'Aménagement du  territoire"));
                $this->Ln(3);
                $this->Cell(20,2,"WILAYA de TIZI OUZOU");
                $this->SetFont('Arial', '',12);
                $this->Cell(82);
                $this->Cell(20,2,"ACTE DE NAISSANCE");
                $this->Ln(3);
                $this->SetFont('Arial', '',6);
                $this->Cell(20,2,"DAIRA d'AZAZGA");
                $this->Ln(3);
                $this->Cell(108);
                $this->Cell(20,2,"COPIE INTEGRALE (1) - Extrait (2)");
                $this->Ln(6);
                $this->Cell(50);
                $this->Cell(20,2,utf8_decode("Etabli en langue étrangère en application de l'article 127 de l'ordonnance n°70-20 du février 1970 relative à l'état civil modifiée et completée"));
                $this->Ln(20);
            }
            
            function a($bdd)
            {
                $this->SetFont('Arial', '',10);
                $this->Cell(60);
                $ID = $_GET['ID'];
                $req = $bdd->query("SELECT * FROM citoyens WHERE ID = '$ID'");
                $res = $req->fetch();
                extract($res);

                // $req = $bdd->query('SELECT Date_Recup FROM demande');
                // $res = $req->fetch();
                $Date = explode('-', $DN);
                $DateP = explode('-', $DNP);
                $DateM = explode('-', $DNM);
                
                $this->Cell(20,2,"Le(3).................................................................................................... ");
                $this->Cell(22,2,$this->SetFont('Arial', 'B',10) . asLetters($Date[2]) . "  " . Months($Date[1]) . "  " . asLetters($Date[0]));
                $this->Ln(9);
                $this->Cell(60);
                $this->Cell(8, 2, $this->SetFont('Arial', '',10) . utf8_decode("À........................................................................................................................."));
                $this->Cell(1,2,$this->SetFont('Arial', 'B',10) . Heure($HN));
                $this->Cell(30, 2,$this->SetFont('Arial', '',10) . $this->Cell(40) . utf8_decode("est né   À"));
                $this->Cell(20, 2,  $this->SetFont('Arial', 'B',10) . utf8_decode($LN));
                $this->Ln(9);
                $this->Cell(8);
                $this->Cell(4, 2, utf8_decode(" N° "));
                $this->Cell(8,2,".......................");
                $this->Cell(40, 2, $NumActe);
                $this->Cell(1,2, $this->SetFont('Arial', '',10) . "(4)....................................................................................................................... ");
                $this->Cell(60, 2,$this->SetFont('Arial', 'B',10) . $this->Cell(40) . utf8_decode($Nom . "  " . $Prenom ));
                $this->Ln(9);
                $this->Cell(12);
                
                $this->Cell(48, 2, utf8_decode(date('d/m/Y', strtotime($DN))));
                $this->Cell(13, 2,$this->SetFont('Arial', '',10) . "De sexe");
                $this->Cell(7, 2, $this->SetFont('Arial', '',10) . ".............................................................................................................. ");
                $this->Cell(30, 2,$this->SetFont('Arial', 'B',10) . $Sexe  );
                $this->Cell(30, 2,$this->SetFont('Arial', '',10) . "Fils de ");
                $this->Cell(20, 2,$this->SetFont('Arial', 'B',10) . $Nom . "  " . $PrenomP);
                $this->Ln(9);
                $this->Cell(60);
                $this->Cell(1, 2, $this->SetFont('Arial', '',10) . "............................................................................................................................ ");
                $this->Cell(40, 2, $this->SetFont('Arial', 'B',10) ."     Ben " . $PrenomGPP);
                $this->Cell(14, 2,  $this->SetFont('Arial', '',10) . utf8_decode(", agé de "));
                $this->Cell(20, 2,  $this->SetFont('Arial', 'B',10) . utf8_decode(asLetters($Date[0]-$DateP[0]) . " ans,    " . $ProfP));
                $this->Ln(1);
                $this->Cell(45, 10, "VALABLE UNIQUEMENT", "LTR", "0", "C");
                $this->Cell(15);
                $this->Ln(8);
                $this->Cell(45, 5, "A L'ETRANGER", "LBR", "0", "C");
                $this->Cell(15);
                $this->Cell(8, 2,$this->SetFont('Arial', '',10) . "Et de ");
                $this->Cell(1, 2, $this->SetFont('Arial', '',10) . ".................................................................................................................... ");
                $this->Cell(5);
                $this->Cell(53, 2,$this->SetFont('Arial', 'B',10) . utf8_decode($NomM . "  " . $PrenomM . "  Bent  " . $PrenomGPM));
                $this->Cell(18, 2,$this->SetFont('Arial', '',10) . utf8_decode(", agée de "));
                $this->Cell(10, 2,$this->SetFont('Arial', 'B',10) . asLetters($Date[0]-$DateM[0]) . " ans ");
                $this->Ln(9);
                $this->Cell(60);
                $this->Cell(50, 2, $this->SetFont('Arial', '',10) . "............................................................................................................................ ");
                $this->Cell(20, 2,$this->SetFont('Arial', 'B',10) . utf8_decode($ProfM));
                $this->Ln(9);
                $this->Cell(60);
                $this->Cell(16, 2,$this->SetFont('Arial', '',10) . utf8_decode("Domiciliés "));
                $this->Cell(16, 2, "............................................................................................................ ");
                $this->Cell(20, 2,$this->SetFont('Arial', 'B',10) . utf8_decode($Adresse));
                $this->Ln(9);
                $this->Cell(60);
                $this->Cell(5, 2, $this->SetFont('Arial', '',10) . "............................................................................................................................ ");
                $this->Cell(17, 2,$this->SetFont('Arial', '',10) . utf8_decode("Dressé le  "));
                $this->Cell(40, 2,$this->SetFont('Arial', 'B',10) . asLetters($Date[2]) . "  " . Months($Date[1]) . "  " . asLetters($Date[0]));
                $this->Ln(9);
                $this->Cell(60);
                $this->Cell(20, 2, $this->SetFont('Arial', '',10) . "................................................................................................. ");
                $this->Cell(5, 2, utf8_decode("à"));
                $this->Cell(40, 2,$this->SetFont('Arial', 'B',10) . Heure($HD));
                $this->Cell(30);
                $this->Cell(5, 2,$this->SetFont('Arial', '',10) . "sur la declaration");
                $this->Ln(9);
                $this->Cell(60);
                $this->Cell(17, 2,$this->SetFont('Arial', '',10) . utf8_decode("dressé par "));
                $this->Cell(13, 2, "........................................................................................................... ");
                $this->Cell(5, 2,$this->SetFont('Arial', 'B',10) . utf8_decode("ASLI Mohand, Employé de l'hôpital"));
                $this->Ln(9);
                $this->Cell(60);
                $this->Cell(1, 2,$this->SetFont('Arial', '',10) . utf8_decode("qui, lecture faite, a signé avec nous "));
                $this->Cell(59, 2, $this->SetFont('Arial', '',10) . "........................................................................................................................... ");
                $this->Cell(40, 2,$this->SetFont('Arial', 'B',10) . utf8_decode("BOUADI Mustapha"));
                $this->Cell(30, 2,$this->SetFont('Arial', '',10) . utf8_decode("  Le "));
                $this->Ln(9);
                $this->Cell(60);
                $this->Cell(1, 2, $this->SetFont('Arial', '',10) . utf8_decode("Président de l'Assemblée Populaire Communale d'Azazga, Officier de l'état"));
                $this->Cell(59, 2, $this->SetFont('Arial', '',10) . "........................................................................................................................... ");
                $this->Ln(9);
                $this->Cell(60);
                $this->Cell(1, 2, utf8_decode("civil"));
                $this->Cell(59, 2, "........................................................................................................................... ");
                $this->Ln(9);
                $this->Cell(60);
                $this->Cell(60, 2, "......................................$InfMar...................................................................................... ");
                $this->Ln(9);
                $this->Cell(60);
                $this->Cell(60, 2, "............................................................................................................................ ");
                $this->Ln(9);
                $this->Cell(60);
                $this->Cell(60, 2, "............................................................................................................................ ");
                $this->Ln(40);
                $this->Cell(60);
                $this->Cell(60, 2, "............................................................................................................................ ");
                $this->Cell(30, 2, $this->SetFont('Arial', 'B',11) . utf8_decode("FAIT A AZAZGA LE   " . date("d/m/y")));
                $this->Ln(6);
                $this->Cell(60, 2, $this->SetFont('Arial', '',6) . "1 et 2 Rayer les mentions inutiles" );
                $this->Ln(5);
                $this->Cell(130, 2, $this->SetFont('Arial', '',6) . "3 en toutes lettres" );
                $this->Cell(60, 2, $this->SetFont('Arial', '',11) . "L'officier de l'etat civil" );
                $this->Ln(5);
                $this->Cell(110, 2, $this->SetFont('Arial', '',6) . "4 Nom et prenom de l'enfant" );
                $this->Cell(60, 2, $this->SetFont('Arial', '',11) . utf8_decode("Nom et Prenom qualité Signature et Cachet" ));
            }

            // Pied de page
            function Footer()
            {
            
            }
        }
        
        // Instanciation de la classe dérivée
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times','',12);
        $pdf->a($bdd);
        $pdf->Output();
    ?>