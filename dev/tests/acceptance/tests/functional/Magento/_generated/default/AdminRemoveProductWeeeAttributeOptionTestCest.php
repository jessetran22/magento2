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
 * @Title("MAGETWO-95033: Weee attribute options can be removed in product page")
 * @Description("Weee attribute options can be removed in product page<h3>Test files</h3>app/code/Magento/Weee/Test/Mftf/Test/AdminRemoveProductWeeeAttributeOptionTest.xml<br>")
 * @TestCaseId("MAGETWO-95033")
 * @group weee
 */
class AdminRemoveProductWeeeAttributeOptionTestCest
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
		$I->createEntity("createProductFPTAttribute", "hook", "FPTProductAttribute", [], []); // stepKey: createProductFPTAttribute
		$I->createEntity("addFPTToAttributeSet", "hook", "AddToDefaultSet", ["createProductFPTAttribute"], []); // stepKey: addFPTToAttributeSet
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProduct
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [searchForSimpleProductInitial] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForSimpleProductInitial
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForSimpleProductInitial
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForSimpleProductInitial
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForSimpleProductInitial
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForSimpleProductInitialWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createSimpleProduct', 'sku', 'hook')); // stepKey: fillSkuFieldOnFiltersSectionSearchForSimpleProductInitial
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForSimpleProductInitial
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForSimpleProductInitialWaitForPageLoad
		$I->comment("Exiting Action Group [searchForSimpleProductInitial] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [openEditProductInitial] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'hook') . "']]"); // stepKey: clickOnProductRowOpenEditProductInitial
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProductInitial
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createSimpleProduct', 'sku', 'hook')); // stepKey: seeProductSkuOnEditProductPageOpenEditProductInitial
		$I->comment("Exiting Action Group [openEditProductInitial] OpenEditProductOnBackendActionGroup");
		$I->comment("Entering Action Group [addWeeeAttributeValue] AdminProductAddFPTValueActionGroup");
		$I->click("[data-index='" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'hook') . "'] [data-action='add_new_row']"); // stepKey: clickAddFPTButton1AddWeeeAttributeValue
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddWeeeAttributeValue
		$I->selectOption("div.admin__field-control[data-index='" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'hook') . "'] table tbody tr.data-row:last-child select[name*='[country]']", "US"); // stepKey: selectcountryForFPTAddWeeeAttributeValue
		$I->selectOption("div.admin__field-control[data-index='" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'hook') . "'] table tbody tr.data-row:last-child select[name*='[state]']", "California"); // stepKey: selectstateForFPTAddWeeeAttributeValue
		$I->fillField("div.admin__field-control[data-index='" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'hook') . "'] table tbody tr.data-row:last-child input[name*='[value]']", "10"); // stepKey: setTaxvalueForFPTAddWeeeAttributeValue
		$I->comment("Exiting Action Group [addWeeeAttributeValue] AdminProductAddFPTValueActionGroup");
		$I->comment("Entering Action Group [saveProductInitial] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductInitial
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductInitial
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductInitialWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductInitial
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductInitialWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductInitial
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductInitial
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductInitial
		$I->comment("Exiting Action Group [saveProductInitial] SaveProductFormActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToProductListing] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductListing
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductListing
		$I->comment("Exiting Action Group [navigateToProductListing] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [resetGridToDefaultKeywordSearch] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetGridToDefaultKeywordSearch
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetGridToDefaultKeywordSearchWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetGridToDefaultKeywordSearch
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetGridToDefaultKeywordSearch
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetGridToDefaultKeywordSearchWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetGridToDefaultKeywordSearch
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetGridToDefaultKeywordSearch
		$I->comment("Exiting Action Group [resetGridToDefaultKeywordSearch] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->deleteEntity("createProductFPTAttribute", "hook"); // stepKey: deleteProductFPTAttribute
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
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
	 * @Stories({"Weee attribute options can be removed in product page"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Weee"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminRemoveProductWeeeAttributeOptionTest(AcceptanceTester $I)
	{
		$I->comment("Test Steps");
		$I->comment("Step 1: Open created product edit page");
		$I->comment("Entering Action Group [searchForSimpleProduct] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForSimpleProduct
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForSimpleProduct
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForSimpleProduct
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForSimpleProduct
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForSimpleProductWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchForSimpleProduct
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForSimpleProductWaitForPageLoad
		$I->comment("Exiting Action Group [searchForSimpleProduct] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [openEditProduct] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct
		$I->comment("Exiting Action Group [openEditProduct] OpenEditProductOnBackendActionGroup");
		$I->comment("Step 2: Remove weee attribute options");
		$I->click("[data-index='" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'test') . "'] [data-action='remove_row']:nth-of-type(1)"); // stepKey: removeAttributeOption
		$I->comment("Entering Action Group [saveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormActionGroup");
		$I->comment("Assert weee attribute options are empty");
		$I->dontSeeElement("[data-index='" . $I->retrieveEntityField('createProductFPTAttribute', 'attribute_code', 'test') . "'] [data-action='remove_row']:nth-of-type(1)"); // stepKey: dontSeeOptions
	}
}
