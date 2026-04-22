inclusion: manual
Guidelines de Code Review — Backend (PHP)
Baseado nas guidelines gerais, PHP Genérico, Baseclass e Machete. Cada guideline possui um código de identificação único para referência cruzada. Obrigatório: deve ser seguido rigorosamente. Recomendado: boas práticas sugeridas, passíveis de exceções justificadas.

Processo de Review
Etapa 1 — Scan Inicial (2-3 min)
[ ] O código compila/roda sem erros?
[ ] Os testes passam?
[ ] Qual o escopo e propósito da mudança?
[ ] Há red flags óbvias (arquivos grandes, lógica complexa sem testes)?
Etapa 2 — Review Funcional (5-10 min)
[ ] O código faz o que deveria fazer?
[ ] Edge cases estão tratados?
[ ] Error handling é adequado?
[ ] Há erros lógicos?
Etapa 3 — Review de Qualidade (10-15 min)
[ ] Legibilidade e clareza
[ ] Convenções de nomenclatura
[ ] Duplicação de código
[ ] Complexidade ciclomática / carga cognitiva
[ ] Cobertura e qualidade dos testes
Etapa 4 — Review de Segurança (5-10 min)
[ ] Validação de input
[ ] Falhas de autenticação/autorização
[ ] Exposição de dados sensíveis
[ ] Dependências inseguras
[ ] Padrões de vulnerabilidade conhecidos (OWASP Top 10)
Etapa 5 — Review de Performance (5-10 min)
[ ] Eficiência algorítmica
[ ] Otimização de queries
[ ] Oportunidades de cache
[ ] Uso de recursos (memória, conexões, file handles)
[ ] Preocupações de escalabilidade
Formato de Feedback
Ao reportar problemas no review, usar este formato padronizado:

**Problema**: [Descrição clara do problema]
**Localização**: [Arquivo e linha]
**Severidade**: Crítico | Alto | Médio | Baixo
**Sugestão**: [Recomendação específica e acionável]
**Exemplo**: [Código mostrando a melhoria]
Classificação de Severidade
Severidade	Critério	Bloqueia merge?
Crítico	Vulnerabilidades de segurança, risco de corrupção de dados, breaking changes, falhas em testes	Sim
Alto	Problemas de performance, lógica de negócio incorreta, error handling inadequado, falta de testes para funcionalidade core	Sim
Médio	Duplicação de código, otimizações menores, naming inconsistente, documentação ausente	Não (mas recomendado)
Baixo	Preferências de estilo, refatorações menores, testes adicionais	Não
Tom do Feedback
❌ "Esse código está horrível"
❌ "Você não entende como X funciona"
✅ "Considere usar X em vez de Y porque..."
✅ "Você pensou no caso onde...?"
✅ "Funciona, mas poderia ser melhorado com..."
Boas Práticas Gerais
BP001 — Remover variáveis não utilizadas
Severidade: Obrigatório
Por quê: Variáveis não utilizadas aumentam a complexidade desnecessária e podem indicar problemas lógicos.
BP002 — Não usar $_REQUEST/$_POST/$_GET diretamente
Severidade: Obrigatório
Por quê: Acesso direto sem filtragem torna o código suscetível a XSS e SQL Injection.
Usar Inbound/Outbound do framework.
BP003 — Não duplicar código
Severidade: Obrigatório
Por quê: Dificulta manutenção, maior risco de bugs, viola DRY. Não duplique código que muda pelos mesmos motivos, mas evite reutilizar código que pode ser alterado por motivos diferentes.
BP004 — Não usar números mágicos
Severidade: Obrigatório
Por quê: Baixa legibilidade, maior risco de erro, dificulta manutenção. Usar constantes, enums ou classes Constants.
// ❌ Ruim
if ($userRole === 3) {
    echo "Acesso de administrador concedido.";
}

// ✅ Bom
if ($userRole === Constants::ROLE_ADMIN) {
    echo "Acesso de administrador concedido.";
}
BP005 — Dar nomes claros
Severidade: Obrigatório
Por quê: Nomes genéricos como $data, $value, process() não deixam claro o objetivo. Nomes devem refletir intenção e domínio de negócio.
// ❌ Ruim
$d = "2025-09-17";
$v = 250;
function calc($v) { return $v * 0.2; }

// ✅ Bom
$purchaseDate = "2025-09-17";
$orderValue = 250;
function calculateTax($orderValue) { return $orderValue * 0.2; }
BP006 — Separar regras de negócio por domínio
Severidade: Obrigatório
Backend = regras, frontend = exibição, banco = dados.
BP007 — Documentar com PHPDoc
Severidade: Obrigatório
Por quê: Facilita leitura, onboarding e conformidade com clean code. Toda função deve ter docblock com finalidade, parâmetros, tipos e retorno.
// ❌ Ruim
function calcularTotal($preco, $quantidade) {
    return $preco * $quantidade;
}

// ✅ Bom
/**
 * Calcula o valor total de uma compra.
 *
 * @param float $preco Preço unitário do produto
 * @param int $quantidade Quantidade de unidades adquiridas
 * @return float Valor total da compra
 */
function calcularTotal(float $preco, int $quantidade): float {
    return $preco * $quantidade;
}
BP008 — Não usar false/null/valores mágicos para estados
Severidade: Obrigatório
Usar constantes ou enums.
BP009 — Preferir exceções a retornos silenciosos
Severidade: Recomendado
Preferir lançar exceções em vez de retornar null ou false silenciosamente.
BP010 — Funções curtas e com responsabilidade única
Severidade: Obrigatório
Por quê: Clareza, reutilização, manutenibilidade e testabilidade.
// ❌ Ruim: função faz múltiplas tarefas
function processarPedido($pedido) {
    if (!$pedido->valido()) return false;
    $total = 0;
    foreach ($pedido->itens as $item) { $total += $item->preco; }
    enviarConfirmacao($pedido);
    salvarPedido($pedido);
    return $total;
}

// ✅ Bom: funções especializadas
function validarPedido($pedido): bool { return $pedido->valido(); }
function calcularTotal($pedido): float { /* ... */ }
function processarPedido($pedido) {
    if (!validarPedido($pedido)) return false;
    $total = calcularTotal($pedido);
    enviarConfirmacao($pedido);
    salvarPedido($pedido);
    return $total;
}
BP011 — Evitar retornos redundantes
Severidade: Obrigatório
Por quê: Retornos duplicados aumentam verbosidade. Usar ??, ?->, ?: para simplificar.
// ❌ Ruim
public function getUserRole(array $user): string {
    if (isset($user['role'])) { return $user['role']; }
    return 'guest';
}

// ✅ Bom
public function getUserRole(array $user): string {
    return $user['role'] ?? 'guest';
}
BP012 — Indentação e espaçamento consistentes
Severidade: Obrigatório
Por quê: Legibilidade, manutenibilidade, colaboração e evita conflitos em merge.
BP013 — Organizar arquivos nas pastas corretas
Severidade: Obrigatório
Por quê: Facilita manutenção, legibilidade e onboarding.
BP014 — Aliases SQL intuitivos e descritivos
Severidade: Obrigatório
Por quê: Aliases de uma única letra prejudicam compreensão. Usar aliases correspondentes ao nome das tabelas.
-- ❌ Ruim
SELECT 1 FROM ASEXECACTIVASSET C
INNER JOIN OBOBJECT O ON O.CDOBJECT = C.CDASSET

-- ✅ Bom
SELECT 1 FROM ASEXECACTIVASSET ASEXECACT
INNER JOIN OBOBJECT OBJ ON OBJ.CDOBJECT = ASEXECACT.CDASSET
BP015 — Executar lint e testes antes de submeter
Severidade: Obrigatório
PHP — Segurança
BS001 — Bind variables em todas as queries
Severidade: Obrigatório
Nunca interpolar variáveis em SQL.
BS002 — Não expor secrets em código ou logs
Severidade: Obrigatório
Por quê: Credenciais hardcoded são vetores de ataque triviais. Usar variáveis de ambiente ou vault.
// ❌ Ruim
$apiKey = "sk-abc123secret";
$logger->info("Conectando com key: $apiKey");

// ✅ Bom
$apiKey = getenv('API_KEY');
$logger->info("Conectando com API externa");
BS003 — Validar e sanitizar todo input do usuário
Severidade: Obrigatório
Por quê: Previne XSS, SQL Injection, command injection e path traversal.
Validar tipo, tamanho, formato e range de todos os inputs.
BS004 — Sessões e tokens seguros
Severidade: Obrigatório
Cookies com flags HttpOnly, Secure, SameSite.
Tokens de sessão com entropia adequada e expiração definida.
BS005 — Verificar autorização em todas as rotas protegidas
Severidade: Obrigatório
Por quê: Previne escalação de privilégios. Não confiar apenas em autenticação — verificar permissões por recurso/ação.
BS006 — Senhas sempre com hash seguro
Severidade: Obrigatório
Usar password_hash() com PASSWORD_BCRYPT ou PASSWORD_ARGON2ID. Nunca MD5/SHA1.
BS007 — Auditar dependências por vulnerabilidades conhecidas
Severidade: Recomendado
Usar composer audit regularmente. Manter dependências atualizadas.
BS008 — Upload de arquivos com validação rigorosa
Severidade: Obrigatório
Validar tipo MIME real (não apenas extensão), tamanho máximo e conteúdo. Nunca salvar em diretório público executável.
PHP — Funcionais (Baseclass)
ID	Regra	Severidade	Nota
BF001	Não usar $_REQUEST/$_POST/$_GET diretamente. Usar Inbound/Outbound	Obrigatório	$inbound->getInteger("campo", -1)
BF002	Usar injeção de dependência em vez de instanciar diretamente	Recomendado	Container DI do framework
BF003	Seguir PSR-12: namespaces, indentação, visibilidade, tipagem, espaçamento	Obrigatório	
BF004	Não deixar queries soltas em arquivos PHP. Usar ISql, SqlByVendor ou ExtensibleSql	Recomendado	Estrutura include/exp/sql
BF005	Tipar argumentos e retornos. Evitar mixed, array genérico ou ausência de tipo	Obrigatório	declare(strict_types=1)
PHP Genérico — Performance e Segurança
ID	Regra	Severidade
P000	Novas tabelas devem ter PKs, FKs e índices. Nunca criar tabela sem constraints	Obrigatório
P001	Usar batch processing em inserções em larga escala (BATCH_SIZE = 500)	Obrigatório
P002	Evitar consultas N+1. Usar eager loading ou joins	Obrigatório
P003	Não fazer flush/persist/query dentro de loops. Acumular e persistir fora	Obrigatório
P004	Usar variável de emergência (contador + limite) em laços while	Obrigatório
P005	Validar resultado do execute antes de iterar	Obrigatório
P014	Usar SqlLookOver para queries em vez de $conn->Execute()	Obrigatório
// ❌ Ruim (P014)
global $conn;
$conn->Execute("SELECT * FROM tabela WHERE campo = '$valor'");

// ✅ Bom (P014)
\SqlLookOver::getInstance()->execute(
    'SELECT * FROM tabela WHERE campo = :valor',
    ['valor' => $valor]
);
PHP Genérico — Arquitetura e Qualidade
ID	Regra	Severidade
P006	Usar container de dependência em vez de instanciar diretamente	Recomendado
P007	Usar declare(strict_types=1) e type hints em todos os arquivos	Obrigatório
P008	Verificar campos por null mesmo quando aparentemente não nulos	Obrigatório
P009	Usar readonly (PHP 8.1+) para propriedades imutáveis	Recomendado
P010	Retornar mensagens de erro claras usando termos (getTerm())	Obrigatório
P011	Usar enums nativos do PHP 8.1+ em vez de constantes soltas	Recomendado
P012	Usar named arguments em chamadas complexas	Recomendado
P017	Usar constantes para valores mágicos em classes	Obrigatório
P018	Preferir composição sobre herança	Recomendado
P019	Usar null coalescing operator (??) em vez de ternários verbosos	Recomendado
P020	Adicionar logs com LoggableTrait para debug futuro	Recomendado
PHP — Testabilidade
ID	Regra	Severidade
BT001	Criar/atualizar testes unitários ao editar arquivos em include/exp	Obrigatório
BT002	Criar teste para bugs corrigidos	Recomendado
P013	Nomenclatura: test{Método}{Motivador}{ResultadoEsperado}	Obrigatório
P014	Testar regras de negócio e comportamento, não linhas específicas	Obrigatório
P015	Criar teste para todo bug corrigido	Recomendado
P016	Usar mocks para dependências externas nos testes	Recomendado
Estrutura de Pastas de Referência
Baseclass
include/exp/generic/{Module}/
├── Contracts/              # Interfaces do domínio
├── Enums/                  # Enumeradores
├── Exceptions/             # Exceções customizadas
├── Formatters/             # Formatadores de dados
├── Models/                 # Modelos
├── Providers/              # Providers de valores
├── Repositories/           # Repositórios
└── Utils/                  # Utilitários
Machete
src/Components/Generic/{Module}/
├── Controllers/Payloads/   # Controllers REST + DTOs
├── Services/               # Regras de negócio
├── Repositories/           # Acesso a dados (Doctrine)
├── Entities/               # Entidades do banco
├── Enums/                  # Enumeradores + Constants
├── Helpers/                # Classes auxiliares
├── Exceptions/             # Exceções customizadas
└── Traits/                 # Traits reutilizáveis
Resource Management
RM001 — Fechar recursos explicitamente
Severidade: Obrigatório
Por quê: File handles, conexões de banco e streams não fechados causam memory leaks e esgotamento de recursos.
// ❌ Ruim — resource leak
function processarArquivo(string $caminho): string {
    $handle = fopen($caminho, 'r');
    $conteudo = fread($handle, filesize($caminho));
    processar($conteudo);
    // handle nunca fechado
    return $conteudo;
}

// ✅ Bom — recurso fechado com try/finally
function processarArquivo(string $caminho): string {
    $handle = fopen($caminho, 'r');
    try {
        $conteudo = fread($handle, filesize($caminho));
        processar($conteudo);
        return $conteudo;
    } finally {
        fclose($handle);
    }
}
RM002 — Configurar timeouts em conexões externas
Severidade: Obrigatório
Por quê: Chamadas sem timeout podem travar o processo indefinidamente.
Definir timeout para HTTP requests, conexões de banco e operações de I/O.
RM003 — Usar connection pooling
Severidade: Recomendado
Por quê: Criar/destruir conexões a cada request é custoso. Reutilizar conexões via pool.
Concorrência e Thread Safety
CC001 — Proteger recursos compartilhados
Severidade: Obrigatório
Por quê: Acesso concorrente sem proteção causa race conditions e dados corrompidos.
Usar locks, mutexes ou transações de banco quando múltiplos processos acessam o mesmo recurso.
CC002 — Usar transações para operações atômicas
Severidade: Obrigatório
Por quê: Operações parciais deixam dados em estado inconsistente.
// ❌ Ruim — sem transação, falha parcial possível
$repo->salvarPedido($pedido);
$repo->atualizarEstoque($pedido->itens);
$repo->registrarPagamento($pedido->pagamento);

// ✅ Bom — transação garante atomicidade
$conn->beginTransaction();
try {
    $repo->salvarPedido($pedido);
    $repo->atualizarEstoque($pedido->itens);
    $repo->registrarPagamento($pedido->pagamento);
    $conn->commit();
} catch (\Throwable $e) {
    $conn->rollBack();
    throw $e;
}
CC003 — Evitar deadlocks
Severidade: Obrigatório
Adquirir locks sempre na mesma ordem. Usar timeouts em locks. Manter transações curtas.
Anti-patterns Comuns
AP001 — Silent Failures (Falhas Silenciosas)
Severidade: Crítico
// ❌ Ruim — erro engolido silenciosamente
try {
    $this->processarPagamento($pedido);
} catch (\Exception $e) {
    // nada acontece
}

// ✅ Bom — erro logado e relançado
try {
    $this->processarPagamento($pedido);
} catch (\Exception $e) {
    $this->logger->error('Falha no pagamento', [
        'pedidoId' => $pedido->getId(),
        'erro' => $e->getMessage(),
    ]);
    throw new PagamentoException('Falha ao processar pagamento', 0, $e);
}
AP002 — God Class / God Method
Severidade: Alto
Por quê: Classes/métodos que fazem tudo violam SRP, são impossíveis de testar e difíceis de manter.
Se um método tem mais de 30 linhas ou uma classe mais de 300, provavelmente precisa ser dividida.
AP003 — Null Handling Ausente
Severidade: Alto
// ❌ Ruim — crash se user ou profile for null
function getEmailUsuario($user): string {
    return strtolower($user->getProfile()->getEmail());
}

// ✅ Bom — null check explícito
function getEmailUsuario($user): string {
    $profile = $user?->getProfile();
    $email = $profile?->getEmail();
    if ($email === null) {
        throw new \InvalidArgumentException('Email do usuário não encontrado');
    }
    return strtolower($email);
}
AP004 — Acoplamento com Estado Global
Severidade: Alto
Por quê: global $var, singletons mutáveis e variáveis estáticas compartilhadas tornam o código imprevisível e impossível de testar.
Preferir injeção de dependência.
AP005 — Retornar tipos mistos para indicar erro
Severidade: Médio
// ❌ Ruim — retorna false para erro, string para sucesso
function buscarUsuario(int $id): string|false {
    $user = $this->repo->find($id);
    return $user ? $user->getNome() : false;
}

// ✅ Bom — exceção para erro, tipo claro para sucesso
function buscarUsuario(int $id): string {
    $user = $this->repo->find($id);
    if ($user === null) {
        throw new UsuarioNaoEncontradoException("Usuário $id não encontrado");
    }
    return $user->getNome();
}
Checklist Final de Aprovação
Antes de aprovar um PR:

[ ] Todos os problemas Críticos e Altos foram resolvidos
[ ] Testes passando
[ ] Sem vulnerabilidades de segurança
[ ] Performance aceitável
[ ] Código segue os padrões do projeto
[ ] Documentação atualizada (PHPDoc, README se necessário)
[ ] Breaking changes documentados
[ ] Feedback construtivo e específico foi dado