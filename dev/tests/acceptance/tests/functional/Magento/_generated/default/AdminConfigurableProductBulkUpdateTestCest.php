<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-88: admin should be able to bulk update attributes of configurable products")
 * @Description("admin should be able to bulk update attributes of configurable products<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdminConfigurableProductUpdateTest/AdminConfigurableProductBulkUpdateTest.xml<br>")
 * @TestCaseId("MC-88")
 * @group ConfigurableProduct
 */
class AdminConfigurableProductBulkUpdateTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct1", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createProduct1
		$I->createEntity("createProduct2", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createProduct2
		$I->createEntity("createProduct3", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createProduct3
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct1", "hook"); // stepKey: deleteFirstProduct
		$I->deleteEntity("createProduct2", "hook"); // stepKey: deleteSecondProduct
		$I->deleteEntity("createProduct3", "hook"); // stepKey: deleteThirdProduct
		$I->comment("Entering Action Group [goToProductList] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageGoToProductList
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadGoToProductList
		$I->comment("Exiting Action Group [goToProductList] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [clearProductsGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearProductsGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearProductsGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductsGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"ConfigurableProduct"})
	 * @Stories({"Create, Read, Update, Delete"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminConfigurableProductBulkUpdateTest(AcceptanceTester $I)
	{
		$I->comment("Search for prefix of the 3 products we created via api");
		$I->comment("Entering Action Group [goToProductList] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageGoToProductList
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadGoToProductList
		$I->comment("Exiting Action Group [goToProductList] AdminOpenProductIndexPageActionGroup");
		$I->conditionalClick(".admin__data-grid-header .admin__data-grid-filters-current._show .action-clear", ".admin__data-grid-header .admin__data-grid-filters-current._show .action-clear", true); // stepKey: clearAll
		$I->waitForPageLoad(30); // stepKey: clearAllWaitForPageLoad
		$I->comment("Entering Action Group [searchForProduct] SearchProductGridByKeywordActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialSearchForProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialSearchForProductWaitForPageLoad
		$I->fillField("input#fulltext", "API Configurable Product" . msq("ApiConfigurableProduct")); // stepKey: fillKeywordSearchFieldSearchForProduct
		$I->click(".data-grid-search-control-wrap button.action-submit"); // stepKey: clickKeywordSearchSearchForProduct
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchForProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSearchSearchForProduct
		$I->comment("Exiting Action Group [searchForProduct] SearchProductGridByKeywordActionGroup");
		$I->comment("Select all, then start the bulk update attributes flow");
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdown
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGrid
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdown
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Update attributes']"); // stepKey: clickBulkUpdate
		$I->waitForPageLoad(30); // stepKey: clickBulkUpdateWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: wait2
		$I->comment("Update the description");
		$I->click("#toggle_description"); // stepKey: clickToggleDescription
		$I->fillField("#description", "MFTF automation!"); // stepKey: fillDescription
		$I->click("button[title=Save]"); // stepKey: clickSave
		$I->waitForPageLoad(30); // stepKey: clickSaveWaitForPageLoad
		$I->waitForElementVisible(".message.message-success.success", 60); // stepKey: waitForSuccessMessage
		$I->see("Message is added to queue", ".message.message-success.success"); // stepKey: seeAttributeUpdateSuccessMsg
		$I->comment("Apply changes");
		$I->comment("Entering Action Group [startMessageQueue] CliConsumerStartActionGroup");
		$startMessageQueueStartMessageQueue = $I->magentoCLI("queue:consumers:start product_action_attribute.update --max-messages=100", 60); // stepKey: startMessageQueueStartMessageQueue
		$I->comment($startMessageQueueStartMessageQueue);
		$I->comment("Exiting Action Group [startMessageQueue] CliConsumerStartActionGroup");
		$I->comment("Check storefront for description");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToFirstProductPageOnStorefront
		$I->waitForPageLoad(30); // stepKey: waitForFirstProductPageLoad
		$I->see("MFTF automation!", "#description .value"); // stepKey: seeFirstDescription
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToSecondProductPageOnStorefront
		$I->waitForPageLoad(30); // stepKey: waitForSecondProductPageLoad
		$I->see("MFTF automation!", "#description .value"); // stepKey: seeSecondDescription
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct3', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToThirdProductPageOnStorefront
		$I->waitForPageLoad(30); // stepKey: waitForThirdProductPageLoad
		$I->see("MFTF automation!", "#description .value"); // stepKey: seeThirdDescription
	}
}
