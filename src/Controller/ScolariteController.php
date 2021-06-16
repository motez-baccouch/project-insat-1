<?php

namespace App\Controller;


use App\Entity\Filiere;
use App\Entity\Note;
use App\Form\ScolariteType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScolariteController extends AbstractController
{
    #[Route('/scolarite', name: 'scolarite')]
    public function index(Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository('App:Filiere');
        $repository2 = $this->getDoctrine()->getRepository('App:MatiereNiveauFiliere');
        $filiere = $repository->findall();


        $filieres=array();
        foreach($filiere as $fil){
            $niveau=$fil->getNiveaux();
            $fila=$fil->getFiliere();
            $filieres[$fila]=array();
            foreach($niveau as $niv){
                array_push($filieres[$fila],$niv->getNiveau());


    }
        }



        return $this->render('scolarite/index.html.twig', [
            'controller_name' => 'ScolariteController',
            'filieres'=>$filieres,
             'title' => 'Scolarite',

        ]);
    }


    #[Route('/scolarite/{semester}/{filiere}/{niveau}/{matiere}/{type}', name: 'notes')]
    public function notes(Request $request,int $semester,string $filiere,int $niveau, string $type,string $matiere): Response
    {
        $repository = $this->getDoctrine()->getRepository('App:Etudiant');
        $repository2 = $this->getDoctrine()->getRepository('App:Matiere');
        $repository3 = $this->getDoctrine()->getRepository('App:MatiereNiveauFiliere');
        $repository4 = $this->getDoctrine()->getRepository('App:Filiere');
        $repository5 = $this->getDoctrine()->getRepository('App:Niveau');

        $fil=$repository4->findOneBy(['filiere'=>$filiere]);
        $niv=$repository5->findOneBy(['niveau'=>$niveau]);

        $etudiants=$repository->findAll();
        $mat=$repository2->findOneBy(['nom'=>$matiere]);
        if(!$mat){return $this->redirectToRoute('not_found');}
        if(!$fil){return $this->redirectToRoute('not_found');}
        if(!$niv){return $this->redirectToRoute('not_found');}

        if($semester!=1 && $semester!=2){return $this->redirectToRoute('not_found');}
        if(strtoupper($type)<>"DS" && strtoupper($type)<>"TP" && strtoupper($type)!="EXAM"){return $this->redirectToRoute('not_found');}

        $matNivFil=$repository3->findOneBy(['matiere'=>$mat]);

        $notes=array();

        foreach($etudiants as $etudiant){
            if($etudiant->getFiliere()->getFiliere()==$filiere && $etudiant->getNiveau()->getNiveau()==$niveau ){

                $note=new Note();
                $note->setAnneScolaire(2021);
                $note->setEtudiant($etudiant);
                $note->setMatiere($matNivFil);
                $note->setTpValid(0);
                $note->setDsValid(0);
                $note->setExamenValid(0);

                array_push($notes,$note);

            }
        }


        if($request->isMethod('post')){
            $posts = $request->request->all();
            unset($posts["DataTables_Table_0_length"]);


            $repository4 = $this->getDoctrine()->getRepository('App:Note');

            foreach($posts as $key => $post) {
                foreach ($notes as $note) {
                    if ($note->getEtudiant()->getNumInscription() == $key ) {

                        $etu=$note->getEtudiant();
                        $noteBase=$repository4->findOneBy([
                            'etudiant'=>$etu,'matiere'=>$matNivFil
                             ]);



                        if($noteBase){
                            if($type="DS"){$noteBase->setNoteDS($post);}
                            elseif($type="TP"){$noteBase->setNoteTp($post);}
                            elseif($type="EXAM"){$noteBase->setNoteExamen($post);}
                            $entityManager = $this->getDoctrine()->getManager();
                            $entityManager->flush();
                        }
                        else {
                            if ($type = "DS") {
                                $note->setNoteDS($post);
                            } elseif ($type = "TP") {
                                $note->setNoteTp($post);
                            } elseif ($type = "EXAM") {
                                $note->setNoteExamen($post);
                            }

                            $entityManager = $this->getDoctrine()->getManager();
                            $entityManager->persist($note);
                            $entityManager->flush();
                            }



                    }
                }

            }

        }




        return $this->render('scolarite/notes.html.twig', [
            'etudiants'=>$notes,
            'title' => 'Notes',
        ]);

    }



    #[Route('/scolarite/{semester}/{filiere}/{niveau}', name: 'matiere')]
    public function mats(Request $request,int $semester,string $filiere,int $niveau): Response
    {
        $repository = $this->getDoctrine()->getRepository('App:Filiere');
        $repository2 = $this->getDoctrine()->getRepository('App:MatiereNiveauFiliere');
        $repository3= $this->getDoctrine()->getRepository('App:Niveau');
        $filieres = $repository->findall();
        $niveaux = $repository3->findall();
        $matieres=$repository2->findall();

        foreach($filieres as $fil){
        if($fil->getFiliere()==$filiere){
            $filId=$fil->getId();
            break;
        }
        }

        foreach($niveaux as $niv){
            if($niv->getNiveau()==$niveau){
                $nivId=$niv->getId();
                break;
            }
        }

        foreach($matieres as $mat){
            $matName=$mat->getMatiere()->getNom();

            if($mat->getFiliere()->getId()==$filId && $mat->getNiveau()->getId()==$nivId){
                $matiere[$matName]=array();
                if($mat->getTp()){ array_push($matiere[$matName],"TP");}
                if($mat->getDs()){ array_push($matiere[$matName],"DS");}
                if($mat->getExamen()){ array_push($matiere[$matName],"Exam");}

            }
            else{$matiere=array();}
        }

        return $this->render('scolarite/matieres.html.twig', [
            'controller_name' => 'ScolariteController',
            'matiere'=>$matiere,
            'title' => 'Matieres',
            'semester'=>$semester,
            'filiere'=>$filiere,
            'niveau'=>$niveau
        ]);
    }




}
