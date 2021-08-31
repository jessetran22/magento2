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
 * @Title("MC-6443: Product custom URL Key is preserved when assigned to a Category (without custom URL Key) alongside with another Product without custom URL Key")
 * @Description("The test verifies that product custom URL Key is preserved when assigned to a Category (without custom URL Key) alongside with another Product without custom URL Key.<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminProductCustomURLKeyPreservedWhenAssignedToCategoryWithoutCustomURLKeyTest.xml<br>")
 * @TestCaseId("MC-6443")
 * @group catalog
 */
class AdminProductCustomURLKeyPreservedWhenAssignedToCategoryWithoutCustomURLKeyTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->comment("Create Simple Products");
		$I->createEntity("createSimpleProductFirst", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProductFirst
		$I->createEntity("createSimpleProductSecond", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProductSecond
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->comment("Entering Action Group [createStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreView
		$I->fillField("#store_name", "storeView" . msq("storeViewData")); // stepKey: enterStoreViewNameCreateStoreView
		$I->fillField("#store_code", "storeView" . msq("storeViewData")); // stepKey: enterStoreViewCodeCreateStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreView
		$I->comment("Exiting Action Group [createStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createSimpleProductFirst", "hook"); // stepKey: deleteFirstSimpleProduct
		$I->deleteEntity("createSimpleProductSecond", "hook"); // stepKey: deleteSecondSimpleProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [deleteStoreView] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreViewWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "storeView" . msq("storeViewData")); // stepKey: fillStoreViewFilterFieldDeleteStoreView
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreViewWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreViewWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreViewWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreView
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreView
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreView
		$I->comment("Exiting Action Group [deleteStoreView] AdminDeleteStoreViewActionGroup");
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
	 * @Stories({"Product"})
	 * @Features({"Catalog"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminProductCustomURLKeyPreservedWhenAssignedToCategoryWithoutCustomURLKeyTest(AcceptanceTester $I)
	{
		$I->comment("Open product");
		$I->comment("Entering Action Group [openProductSecondEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createSimpleProductSecond', 'id', 'test')); // stepKey: goToProductOpenProductSecondEditPage
		$I->comment("Exiting Action Group [openProductSecondEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("switch store view");
		$I->comment("Entering Action Group [switchToStoreView] AdminSwitchStoreViewActionGroup");
		$I->click("#store-change-button"); // stepKey: clickStoreViewSwitchDropdownSwitchToStoreView
		$I->waitForElementVisible("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'Default Store View')]", 30); // stepKey: waitForStoreViewsAreVisibleSwitchToStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewsAreVisibleSwitchToStoreViewWaitForPageLoad
		$I->click("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'storeView" . msq("storeViewData") . "')]"); // stepKey: clickStoreViewByNameSwitchToStoreView
		$I->waitForPageLoad(30); // stepKey: clickStoreViewByNameSwitchToStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalSwitchToStoreView
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalSwitchToStoreViewWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchSwitchToStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchSwitchToStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewSwitchedSwitchToStoreView
		$I->scrollToTopOfPage(); // stepKey: scrollToStoreSwitcherSwitchToStoreView
		$I->see("storeView" . msq("storeViewData"), ".store-switcher"); // stepKey: seeNewStoreViewNameSwitchToStoreView
		$I->comment("Exiting Action Group [switchToStoreView] AdminSwitchStoreViewActionGroup");
		$I->comment("set url key");
		$I->conditionalClick("div[data-index='search-engine-optimization']", "input[name='product[url_key]']", false); // stepKey: openSeoSection
		$I->uncheckOption("input[name='use_default[url_key]']"); // stepKey: uncheckUseDefaultUrlKey
		$I->fillField("input[name='product[url_key]']", "U2"); // stepKey: fillUrlKey
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
		$I->comment("Entering Action Group [openCategory] GoToAdminCategoryPageByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/edit/id/" . $I->retrieveEntityField('createCategory', 'id', 'test') . "/"); // stepKey: amOnAdminCategoryPageOpenCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCategory
		$I->see($I->retrieveEntityField('createCategory', 'id', 'test'), ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleOpenCategory
		$I->comment("Exiting Action Group [openCategory] GoToAdminCategoryPageByIdActionGroup");
		$I->comment("Entering Action Group [assignSimpleProductFirst] AdminCategoryAssignProductActionGroup");
		$I->conditionalClick("div[data-index='assign_products']", ".admin__data-grid-header [data-action='grid-filter-reset']", false); // stepKey: clickOnProductInCategoryAssignSimpleProductFirst
		$I->waitForPageLoad(30); // stepKey: clickOnProductInCategoryAssignSimpleProductFirstWaitForPageLoad
		$I->scrollTo("div[data-index='assign_products']", 0, -80); // stepKey: scrollToProductGridAssignSimpleProductFirst
		$I->waitForPageLoad(30); // stepKey: scrollToProductGridAssignSimpleProductFirstWaitForPageLoad
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickOnResetFilterAssignSimpleProductFirst
		$I->waitForPageLoad(30); // stepKey: clickOnResetFilterAssignSimpleProductFirstWaitForPageLoad
		$I->fillField("#catalog_category_products_filter_sku", $I->retrieveEntityField('createSimpleProductFirst', 'sku', 'test')); // stepKey: fillSkuFilterAssignSimpleProductFirst
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchButtonAssignSimpleProductFirst
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonAssignSimpleProductFirstWaitForPageLoad
		$I->click("#catalog_category_products_table tbody tr"); // stepKey: selectProductFromTableRowAssignSimpleProductFirst
		$I->comment("Exiting Action Group [assignSimpleProductFirst] AdminCategoryAssignProductActionGroup");
		$I->comment("Entering Action Group [assignSimpleProductSecond] AdminCategoryAssignProductActionGroup");
		$I->conditionalClick("div[data-index='assign_products']", ".admin__data-grid-header [data-action='grid-filter-reset']", false); // stepKey: clickOnProductInCategoryAssignSimpleProductSecond
		$I->waitForPageLoad(30); // stepKey: clickOnProductInCategoryAssignSimpleProductSecondWaitForPageLoad
		$I->scrollTo("div[data-index='assign_products']", 0, -80); // stepKey: scrollToProductGridAssignSimpleProductSecond
		$I->waitForPageLoad(30); // stepKey: scrollToProductGridAssignSimpleProductSecondWaitForPageLoad
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickOnResetFilterAssignSimpleProductSecond
		$I->waitForPageLoad(30); // stepKey: clickOnResetFilterAssignSimpleProductSecondWaitForPageLoad
		$I->fillField("#catalog_category_products_filter_sku", $I->retrieveEntityField('createSimpleProductSecond', 'sku', 'test')); // stepKey: fillSkuFilterAssignSimpleProductSecond
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchButtonAssignSimpleProductSecond
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonAssignSimpleProductSecondWaitForPageLoad
		$I->click("#catalog_category_products_table tbody tr"); // stepKey: selectProductFromTableRowAssignSimpleProductSecond
		$I->comment("Exiting Action Group [assignSimpleProductSecond] AdminCategoryAssignProductActionGroup");
		$I->comment("Entering Action Group [saveCategory] AdminSaveCategoryFormActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: seeOnCategoryPageSaveCategory
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfTheCategoryPageSaveCategory
		$I->click("#save"); // stepKey: saveCategorySaveCategory
		$I->waitForPageLoad(30); // stepKey: saveCategorySaveCategoryWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageAppearsSaveCategory
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveCategory
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: assertSuccessMessageSaveCategory
		$I->comment("Exiting Action Group [saveCategory] AdminSaveCategoryFormActionGroup");
		$categoryNameLower = $I->executeJS("return '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "'.toLowerCase();"); // stepKey: categoryNameLower
		$simpleProductFirstNameLower = $I->executeJS("return '" . $I->retrieveEntityField('createSimpleProductFirst', 'custom_attributes[url_key]', 'test') . "'.toLowerCase();"); // stepKey: simpleProductFirstNameLower
		$simpleProductSecondNameLower = $I->executeJS("return '" . $I->retrieveEntityField('createSimpleProductSecond', 'custom_attributes[url_key]', 'test') . "'.toLowerCase();"); // stepKey: simpleProductSecondNameLower
		$I->comment("Make assertions on frontend");
		$I->comment("Entering Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage
		$I->comment("Exiting Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: onCategoryPage
		$I->waitForPageLoad(30); // stepKey: onCategoryPageWaitForPageLoad
		$I->seeInCurrentUrl("{$categoryNameLower}.html"); // stepKey: checkCategryUrlKey
		$I->comment("Open first product");
		$I->click("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProductFirst', 'name', 'test') . "')]"); // stepKey: openFirstProduct
		$I->waitForPageLoad(30); // stepKey: waitForFirstProduct
		$I->seeInCurrentUrl("{$simpleProductFirstNameLower}.html"); // stepKey: checkFirstSimpleProductUrlKey
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onCategoryView
		$I->comment("Open second product");
		$I->click("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProductSecond', 'name', 'test') . "')]"); // stepKey: openSecondProduct
		$I->waitForPageLoad(30); // stepKey: waitForSecondProduct
		$I->seeInCurrentUrl("{$simpleProductSecondNameLower}.html"); // stepKey: checkSecondSimpleProductUrlKey
		$I->comment("Entering Action Group [switchToCustomStoreView] StorefrontSwitchStoreViewActionGroup");
		$I->click("#switcher-language-trigger"); // stepKey: clickStoreViewSwitcherSwitchToCustomStoreView
		$I->waitForElementVisible(".active ul.switcher-dropdown", 30); // stepKey: waitForStoreViewDropdownSwitchToCustomStoreView
		$I->click("li.view-storeView" . msq("storeViewData") . ">a"); // stepKey: clickSelectStoreViewSwitchToCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchToCustomStoreView
		$I->comment("Exiting Action Group [switchToCustomStoreView] StorefrontSwitchStoreViewActionGroup");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: openCategoryPage
		$I->waitForPageLoad(30); // stepKey: openCategoryPageWaitForPageLoad
		$I->seeInCurrentUrl("{$categoryNameLower}.html"); // stepKey: seeCategoryUrlKey
		$I->comment("Open product first");
		$I->click("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProductFirst', 'name', 'test') . "')]"); // stepKey: openFirstSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForFirstSimpleProduct
		$I->seeInCurrentUrl("{$simpleProductFirstNameLower}.html"); // stepKey: assertFirstSimpleProductUrlKey
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: openCategoryView
		$I->waitForPageLoad(30); // stepKey: openCategoryViewWaitForPageLoad
		$I->comment("Open product2");
		$I->click("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProductSecond', 'name', 'test') . "')]"); // stepKey: openSecondSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForSecondSimpleProduct
		$I->seeInCurrentUrl("u2.html"); // stepKey: assertSecondSimpleProductUrlKey
	}
}
