<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DescargaController extends Controller
{
    //
    function descarga_sd_estancia_f03(){//#
        $path=public_path('archivos/F-03_CEDULA_DE_REGISTRO_ESTANCIA.xlsx');
        return response()->download($path);
    }
    function descarga_sd_estadia_f03(){//#
        $path=public_path('archivos/F-03_CEDULA_DE_REGISTRO_ESTADIAS.xlsx');
        return response()->download($path);
    }
    function descarga_reporte_estancia($proces){//*optimizado
        switch($proces){
            case 1:$path=public_path('archivos/Formato Evaluacion Estancias.pdf');
              break;
            case 2:$path=public_path('archivos/Formato Evaluacion Estancias.pdf');
              break;
            case 3:$path=public_path('archivos/Formato Evaluacion Estadias.pdf');
              break;
            case 4:$path=public_path('archivos/Formato Evaluacion Estadias.pdf');
              break;
            case 5://ubicacion
              break;  
            default:
              break;
          }
        return response()->download($path);
    }
    function descarga_carta_responsiva(){//*funcional
        $path=public_path('archivos/Carta de exclusión y autorización.doc');
        return response()->download($path);
    }
    function descarga_carta_presentacion($proces){//*optimizado
        switch($proces){
          case 1:$path=public_path('archivos/carta de presentacion.docx');
            break;
          case 2:$path=public_path('archivos/carta de presentacion.docx');
            break;
          case 3:$path=public_path('archivos/carta de presentacion estadia.docx');
            break;
          case 4:$path=public_path('archivos/carta de presentacion estadia.docx');
            break;
          case 5:$path=public_path('archivos/CARTA DE PRESENTACIÓN SERVICIO SOCIAL.docx');
            break;  
          default:
            break;
        }
        return response()->download($path);
    }
    function descarga_carta_compromiso(){//*unicamente para la carta compromiso de servicio social
      $path=public_path('archivos/CARTA COMPROMISO DE SERVICIO SOCIAL.docx');
      return response()->download($path);
    }

    function descarga_reporte_mensual(){//*unicamente para el reporte mensual de servicio social
      $path=public_path('archivos/REPORTE MENSUAL DE ACTIVIDADES (TF03).docx');
      return response()->download($path);
    }
    function DescargarFormatoDocumento($doc){
      switch($doc){
        case 1:

          break;
        case 2:

          break;
        case 3:

          break;
        case 4:
          $path=public_path('archivos/carta de presentacion.docx');
          break;
        case 5:
          $path=public_path('archivos/F-02_Carta_Aceptacion_Servicio Social.docx');
          break;
        case 6:
          $path=public_path('archivos/F-03_Cedula_Registro_Estancia.pdf');
          break;
        case 7:
          $path=public_path('archivos/DEFINICIÓN DE PROYECTO.pdf');
          break;
        case 8:
          $path=public_path('archivos/CARTA LIBERACIÓN DE SERVICIO SOCIAL.docx');
          break;
        case 9:
          $path=public_path('archivos/CARTA COMPROMISO DE SERVICIO SOCIAL.docx');
          break;
        case 10:
          $path=public_path('archivos/REPORTE MENSUAL DE ACTIVIDADES (TF03).docx');
          break;
        case 11:
          $path=public_path('archivos/REPORTE MENSUAL DE ACTIVIDADES (TF03).docx');
          break;
        case 12:
          $path=public_path('archivos/REPORTE MENSUAL DE ACTIVIDADES (TF03).docx');
          break;
        case 13:
          $path=public_path('archivos/REPORTE MENSUAL DE ACTIVIDADES (TF03).docx');
          break;
        case 14:
          $path=public_path('archivos/REPORTE MENSUAL DE ACTIVIDADES (TF03).docx');
          break;
        case 15:
          $path=public_path('archivos/REPORTE MENSUAL DE ACTIVIDADES (TF03).docx');
          break;
        case 16:
          $path=public_path('archivos/REPORTE MENSUAL DE ACTIVIDADES (TF03).docx');
          break;
        case 17:
          $path=public_path('archivos/REPORTE MENSUAL DE ACTIVIDADES (TF03).docx');
          break;
        case 18:
          $path=public_path('archivos/REPORTE MENSUAL DE ACTIVIDADES (TF03).docx');
          break;
        case 19:
          $path=public_path('archivos/REPORTE MENSUAL DE ACTIVIDADES (TF03).docx');
          break;
        case 20:
          $path=public_path('archivos/REPORTE MENSUAL DE ACTIVIDADES (TF03).docx');
          break;
        case 21:
          $path=public_path('archivos/REPORTE MENSUAL DE ACTIVIDADES (TF03).docx');
          break; 
        default:
          break;       
      }
      return response()->download($path);
    }
}
