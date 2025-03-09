<?php

namespace Controller;

use Application\UseCase\RegisterUserUseCase;
use Application\UseCase\RegisterUserRequest;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Domain\Exception\UserAlreadyExistsException;
use Domain\Exception\ValidationException;

class RegisterUserController
{
    private RegisterUserUseCase $registerUserUseCase;

    public function __construct(RegisterUserUseCase $registerUserUseCase)
    {
        $this->registerUserUseCase = $registerUserUseCase;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        try {
            $data = json_decode($request->getBody()->getContents(), true);

            if (!$data) {
                return $this->errorResponse($response, "Datos inválidos", 400);
            }

            $userRequest = new RegisterUserRequest(
                $data['name'] ?? '',
                $data['email'] ?? '',
                $data['password'] ?? ''
            );

            $user = $this->registerUserUseCase->execute($userRequest);

            // 📌 Aquí debes agregar la respuesta JSON
            $responseData = [
                "id" => $user->id(),
                "name" => $user->name(),
                "email" => $user->email(),
                "createdAt" => $user->createdAt()->format('c')
            ];

            // 🚨 Depuración: Verifica si se genera el JSON correctamente
            error_log("JSON Response: " . json_encode($responseData));

            $response->getBody()->write(json_encode($responseData));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
            
        } catch (UserAlreadyExistsException $e) {
            return $this->errorResponse($response, $e->getMessage(), 400);
        } catch (ValidationException $e) {
            return $this->errorResponse($response, $e->getMessage(), 422);
        } catch (\Exception $e) {
            return $this->errorResponse($response, "Error interno del servidor", 500);
        }
    }


    private function errorResponse(Response $response, string $message, int $statusCode): Response
    {
        $errorData = ["error" => $message];
        error_log("Error Response: " . json_encode($errorData)); // 🚨 Depuración
        $response->getBody()->write(json_encode($errorData));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($statusCode);
    }
}
