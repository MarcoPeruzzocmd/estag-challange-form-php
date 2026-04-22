inclusion: manual
Guidelines de Code Review — Frontend (React / JavaScript)
Baseado nas guidelines gerais e Reactor. Cada guideline possui um código de identificação único para referência cruzada. Obrigatório: deve ser seguido rigorosamente. Recomendado: boas práticas sugeridas, passíveis de exceções justificadas.

Processo de Review
Etapa 1 — Scan Inicial (2-3 min)
[ ] O código roda sem erros no console?
[ ] Os testes passam?
[ ] Qual o escopo e propósito da mudança?
[ ] Há red flags óbvias (componentes gigantes, lógica no render)?
Etapa 2 — Review Funcional (5-10 min)
[ ] O componente faz o que deveria?
[ ] Edge cases estão tratados (loading, erro, vazio, lista longa)?
[ ] Error handling é adequado?
[ ] Há erros lógicos?
Etapa 3 — Review de Qualidade (10-15 min)
[ ] Legibilidade e clareza
[ ] Convenções de nomenclatura
[ ] Duplicação de código
[ ] Complexidade dos componentes (muitas responsabilidades?)
[ ] Cobertura e qualidade dos testes
Etapa 4 — Review de Acessibilidade e Segurança (5-10 min)
[ ] Semântica HTML correta
[ ] ARIA labels e roles onde necessário
[ ] Navegação por teclado funcional
[ ] Contraste de cores adequado
[ ] Sanitização de output (XSS)
[ ] Dados sensíveis não expostos no client
Etapa 5 — Review de Performance (5-10 min)
[ ] Re-renders desnecessários
[ ] Memoização adequada
[ ] Bundle size (imports desnecessários?)
[ ] Lazy loading onde aplicável
Formato de Feedback
Ao reportar problemas no review, usar este formato padronizado:

**Problema**: [Descrição clara do problema]
**Localização**: [Arquivo e linha]
**Severidade**: Crítico | Alto | Médio | Baixo
**Sugestão**: [Recomendação específica e acionável]
**Exemplo**: [Código mostrando a melhoria]
Classificação de Severidade
Severidade	Critério	Bloqueia merge?
Crítico	Vulnerabilidades XSS, dados sensíveis expostos, crash em produção	Sim
Alto	Problemas de performance graves, lógica incorreta, falta de error handling, acessibilidade quebrada	Sim
Médio	Duplicação de código, naming inconsistente, documentação ausente, otimizações menores	Não (mas recomendado)
Baixo	Preferências de estilo, refatorações menores	Não
Tom do Feedback
❌ "Esse código está horrível"
❌ "Você não entende como hooks funcionam"
✅ "Considere usar X em vez de Y porque..."
✅ "Você pensou no caso onde o array está vazio?"
✅ "Funciona, mas poderia ser melhorado com..."
Boas Práticas Gerais
BP001 — Remover variáveis não utilizadas
Severidade: Obrigatório
Por quê: Variáveis não utilizadas aumentam a complexidade desnecessária e podem indicar problemas lógicos.
BP003 — Não duplicar código
Severidade: Obrigatório
Por quê: Dificulta manutenção, maior risco de bugs, viola DRY. Separar responsabilidades mesmo que a lógica atual seja igual, se os motivos de mudança forem diferentes.
BP004 — Não usar números mágicos
Severidade: Obrigatório
Por quê: Baixa legibilidade, maior risco de erro, dificulta manutenção. Usar constantes ou enums.
// ❌ Ruim
if (userRole === 3) { console.log("Admin"); }

// ✅ Bom
const ROLE_ADMIN = 3;
if (userRole === ROLE_ADMIN) { console.log("Admin"); }
BP005 — Dar nomes claros
Severidade: Obrigatório
Por quê: Nomes genéricos como data, value, process() não deixam claro o objetivo. Nomes devem refletir intenção e domínio de negócio.
BP006 — Separar regras de negócio por domínio
Severidade: Obrigatório
Backend = regras, frontend = exibição, banco = dados.
BP007 — Documentar com JSDoc
Severidade: Obrigatório
Por quê: Facilita leitura, onboarding e conformidade com clean code. Toda função deve ter docblock com finalidade, parâmetros, tipos e retorno.
// ❌ Ruim
function calcularTotal(preco, quantidade) {
    return preco * quantidade;
}

// ✅ Bom
/**
 * Calcula o valor total de uma compra.
 * @param {number} preco - Preço unitário do produto
 * @param {number} quantidade - Quantidade de unidades
 * @returns {number} Valor total da compra
 */
function calcularTotal(preco, quantidade) {
    return preco * quantidade;
}
BP008 — Não usar false/null/valores mágicos para estados
Severidade: Obrigatório
Usar constantes ou enums.
BP010 — Funções curtas e com responsabilidade única
Severidade: Obrigatório
Por quê: Clareza, reutilização, manutenibilidade e testabilidade. Extrair responsabilidades em funções separadas.
BP011 — Evitar retornos redundantes
Severidade: Obrigatório
Usar operadores ??, ?: para simplificar fluxo.
BP012 — Indentação e espaçamento consistentes
Severidade: Obrigatório
Por quê: Legibilidade, manutenibilidade, colaboração e evita conflitos em merge.
BP013 — Organizar arquivos nas pastas corretas
Severidade: Obrigatório
Por quê: Facilita manutenção, legibilidade e onboarding.
BP015 — Executar lint e testes antes de submeter
Severidade: Obrigatório
BP017 — Testes unitários obrigatórios para reactorCmps/src
Severidade: Obrigatório
Por quê: Regressão, confiabilidade e manutenção. Alterações sem testes podem introduzir falhas silenciosas.
React — Performance
RP001 — Usar memo() em componentes repetidos
Severidade: Recomendado
Em listas/grids.
RP002 — Usar useCallback() em funções passadas como props
Severidade: Obrigatório
Ou usadas em dependências de hooks.
React — Funcionais
ID	Regra	Severidade
RF001	Usar Redux para estado compartilhado entre múltiplos componentes	Obrigatório
RF002	Usar PropTypes para declarar tipos esperados das props	Obrigatório
RF003	Usar componentes funcionais com hooks. Não usar classes. Export no final do arquivo	Obrigatório
RF004	Usar const por padrão. let apenas quando o valor muda	Obrigatório
RF005	Ordem dos imports: bibliotecas externas → framework → componentes internos	Obrigatório
RF006	Usar caminho completo nos imports (reactorCmps/src/...)	Recomendado
RF007	Export único em arquivos Redux. Importar com * as	Recomendado
RF008	Usar immutable no Redux para manter estado imutável	Obrigatório
RF009	Retorno direto em arrow functions simples: () => ({...})	Recomendado
RF010	Usar shorthand property: { cdTask } em vez de { cdTask: cdTask }	Recomendado
RF011	Usar desestruturação: const { name, age } = user	Recomendado
RF012	Validar timestamps do backend com util.toUTC() e util.fromUTC()	Obrigatório
RF014	Usar SCSS para estilos personalizados. Arquivo styles.scss na raiz do componente	Obrigatório
React — Testabilidade
ID	Regra	Severidade
RT001	Nomenclatura de arquivos: NomeDoArquivo.test.js	Obrigatório
RT002	Estrutura de pastas dos testes deve espelhar a do código	Obrigatório
RT003	Describe deve refletir caminho: "Modulo > Feature > Componente test"	Obrigatório
RT004	Testar lógica de funções isoladamente, não apenas comportamento visual	Obrigatório
Estrutura de Pastas de Referência (Reactor)
reactorCmps/
├── components/                # Componentes reutilizáveis cross-domínio
├── {Dominio}/{Feature}/
│   ├── hooks/
│   ├── components/
│   │   └── store/redux/       # actions, actionTypes, reducers, selectors
│   └── style.scss
├── enums/
├── hooks/
├── store/
└── tests/                     # Espelha estrutura do código
Acessibilidade (a11y)
A001 — Usar HTML semântico
Severidade: Obrigatório
Por quê: Leitores de tela e tecnologias assistivas dependem de semântica correta.
Usar <button> para ações, <a> para navegação, <nav>, <main>, <section>, <article> para estrutura.
// ❌ Ruim — div clicável sem semântica
<div onClick={handleSubmit} className="botao">Enviar</div>

// ✅ Bom — elemento semântico
<button type="submit" onClick={handleSubmit}>Enviar</button>
A002 — ARIA labels em elementos interativos
Severidade: Obrigatório
Todo elemento interativo sem texto visível deve ter aria-label ou aria-labelledby.
Ícones clicáveis devem ter texto alternativo.
// ❌ Ruim — botão de ícone sem label
<button onClick={onClose}><IconX /></button>

// ✅ Bom — acessível para leitores de tela
<button onClick={onClose} aria-label="Fechar modal"><IconX /></button>
A003 — Navegação por teclado
Severidade: Obrigatório
Todos os elementos interativos devem ser acessíveis via Tab.
Modais devem ter focus trap. Menus dropdown devem suportar setas.
Não remover outline de focus sem substituir por indicador visual alternativo.
A004 — Imagens com alt text
Severidade: Obrigatório
Imagens informativas devem ter alt descritivo. Imagens decorativas devem ter alt="".
A005 — Contraste de cores
Severidade: Recomendado
Texto deve ter ratio de contraste mínimo de 4.5:1 (AA) contra o fundo.
Texto grande (18px+ ou 14px+ bold): ratio mínimo de 3:1.
A006 — Formulários acessíveis
Severidade: Obrigatório
Todo input deve ter <label> associado (via htmlFor/id ou wrapping).
Mensagens de erro devem ser associadas ao campo via aria-describedby.
// ❌ Ruim — input sem label
<input type="email" placeholder="Email" />

// ✅ Bom — label associado
<label htmlFor="email">Email</label>
<input id="email" type="email" aria-describedby="email-error" />
{erro && <span id="email-error" role="alert">{erro}</span>}
Segurança Frontend
SF001 — Nunca usar dangerouslySetInnerHTML sem sanitização
Severidade: Crítico
Por quê: Vetor direto de XSS. Se necessário, sanitizar com DOMPurify ou similar.
// ❌ Ruim — XSS direto
<div dangerouslySetInnerHTML={{ __html: userInput }} />

// ✅ Bom — sanitizado
import DOMPurify from 'dompurify';
<div dangerouslySetInnerHTML={{ __html: DOMPurify.sanitize(userInput) }} />
SF002 — Não armazenar dados sensíveis no client
Severidade: Obrigatório
Por quê: localStorage, sessionStorage e cookies não-HttpOnly são acessíveis via JavaScript.
Tokens de autenticação devem estar em cookies HttpOnly. Nunca armazenar senhas ou PII no client.
SF003 — Validar dados do backend antes de renderizar
Severidade: Recomendado
Por quê: Dados inesperados do backend podem causar crashes ou comportamento incorreto.
Validar tipos e estrutura antes de usar.
SF004 — Não expor informações de debug em produção
Severidade: Obrigatório
Remover console.log com dados sensíveis. Não exibir stack traces para o usuário.
Error Boundaries e Tratamento de Erros
EB001 — Usar Error Boundaries em áreas críticas
Severidade: Obrigatório
Por quê: Um erro em um componente filho não deve derrubar a aplicação inteira.
// ✅ Error Boundary para seções críticas
<ErrorBoundary fallback={<p>Algo deu errado. Tente novamente.</p>}>
  <PainelPedidos />
</ErrorBoundary>
EB002 — Tratar estados de loading, erro e vazio
Severidade: Obrigatório
Por quê: Todo componente que busca dados deve tratar os 3 estados: carregando, erro e sem dados.
// ❌ Ruim — só trata o caso feliz
function ListaProdutos() {
  const { data } = useFetch('/api/produtos');
  return data.map(p => <Produto key={p.id} {...p} />);
}

// ✅ Bom — trata todos os estados
function ListaProdutos() {
  const { data, loading, error } = useFetch('/api/produtos');

  if (loading) return <Spinner />;
  if (error) return <MensagemErro mensagem="Erro ao carregar produtos" />;
  if (!data?.length) return <EstadoVazio mensagem="Nenhum produto encontrado" />;

  return data.map(p => <Produto key={p.id} {...p} />);
}
EB003 — Não engolir erros em promises
Severidade: Obrigatório
// ❌ Ruim — erro silencioso
fetch('/api/dados').then(res => res.json()).catch(() => {});

// ✅ Bom — erro tratado
fetch('/api/dados')
  .then(res => res.json())
  .catch(err => {
    console.error('Falha ao buscar dados:', err);
    setError('Não foi possível carregar os dados');
  });
Anti-patterns React
AR001 — Lógica de negócio no componente
Severidade: Alto
Por quê: Componentes devem ser responsáveis pela UI. Lógica de negócio deve ficar em hooks customizados, services ou utils.
AR002 — Props drilling excessivo
Severidade: Médio
Por quê: Passar props por 3+ níveis torna o código frágil. Usar Context, Redux ou composição.
AR003 — useEffect como event handler
Severidade: Alto
// ❌ Ruim — useEffect para reagir a clique
const [clicked, setClicked] = useState(false);
useEffect(() => {
  if (clicked) { enviarFormulario(); }
}, [clicked]);

// ✅ Bom — handler direto
const handleSubmit = () => { enviarFormulario(); };
<button onClick={handleSubmit}>Enviar</button>
AR004 — Estado derivado duplicado
Severidade: Médio
Por quê: Se um valor pode ser calculado a partir de outro estado, não crie um estado separado.
// ❌ Ruim — estado duplicado
const [items, setItems] = useState([]);
const [total, setTotal] = useState(0);
// total precisa ser atualizado manualmente toda vez que items muda

// ✅ Bom — valor derivado
const [items, setItems] = useState([]);
const total = items.reduce((sum, item) => sum + item.preco, 0);
Checklist Final de Aprovação
Antes de aprovar um PR:

[ ] Todos os problemas Críticos e Altos foram resolvidos
[ ] Testes passando
[ ] Sem vulnerabilidades de segurança (XSS, dados expostos)
[ ] Acessibilidade básica garantida (semântica, labels, teclado)
[ ] Performance aceitável (sem re-renders desnecessários)
[ ] Código segue os padrões do projeto
[ ] Documentação atualizada (JSDoc, README se necessário)
[ ] Estados de loading, erro e vazio tratados
[ ] Feedback construtivo e específico foi dado