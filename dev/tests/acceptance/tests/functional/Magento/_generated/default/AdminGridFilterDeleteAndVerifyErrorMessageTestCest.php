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
 * @Title("MC-14272: Grid Filter Delete and Verify Error Message")
 * @Description("Test log in to uI and Delete Grid Filter Test<h3>Test files</h3>app/code/Magento/Ui/Test/Mftf/Test/AdminGridFilterDeleteAndVerifyErrorMessageTest.xml<br>")
 * @TestCaseId("MC-14272")
 * @group uI
 * @group mtf_migrated
 */
class AdminGridFilterDeleteAndVerifyErrorMessageTestCest
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
		$setEnableBackupToYes = $I->magentoCLI("config:set system/backup/functionality_enabled 1", 60); // stepKey: setEnableBackupToYes
		$I->comment($setEnableBackupToYes);
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("rootCategory", "hook", "NewRootCategory", [], []); // stepKey: rootCategory
		$I->createEntity("createProduct", "hook", "defaultSimpleProduct", ["rootCategory"], []); // stepKey: createProduct
		$I->comment("Create website");
		$I->comment("Entering Action Group [createWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageCreateWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadCreateWebsite
		$I->comment("Create Website");
		$I->fillField("#website_name", "Second Website" . msq("customWebsite")); // stepKey: enterWebsiteNameCreateWebsite
		$I->fillField("#website_code", "second_website" . msq("customWebsite")); // stepKey: enterWebsiteCodeCreateWebsite
		$I->click("#save"); // stepKey: clickSaveWebsiteCreateWebsite
		$I->waitForPageLoad(60); // stepKey: clickSaveWebsiteCreateWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadCreateWebsite
		$I->see("You saved the website."); // stepKey: seeSavedMessageCreateWebsite
		$I->comment("Exiting Action Group [createWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Create second store");
		$I->comment("Entering Action Group [createCustomStore] CreateCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageCreateCustomStore
		$I->waitForPageLoad(30); // stepKey: waitForSystemStorePageCreateCustomStore
		$I->click("#add_group"); // stepKey: selectCreateStoreCreateCustomStore
		$I->waitForPageLoad(30); // stepKey: selectCreateStoreCreateCustomStoreWaitForPageLoad
		$I->selectOption("#group_website_id", "Second Website" . msq("customWebsite")); // stepKey: selectMainWebsiteCreateCustomStore
		$I->fillField("#group_name", "store" . msq("customStoreGroup")); // stepKey: fillStoreNameCreateCustomStore
		$I->fillField("#group_code", "store" . msq("customStoreGroup")); // stepKey: fillStoreCodeCreateCustomStore
		$I->selectOption("#group_root_category_id", $I->retrieveEntityField('rootCategory', 'name', 'hook')); // stepKey: selectStoreStatusCreateCustomStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateCustomStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateCustomStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateCustomStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateCustomStore
		$I->comment("Exiting Action Group [createCustomStore] CreateCustomStoreActionGroup");
		$I->comment("Create second store view");
		$I->comment("Entering Action Group [createCustomStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateCustomStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStoreGroup")); // stepKey: selectStoreCreateCustomStoreView
		$I->fillField("#store_name", "EN" . msq("customStoreEN")); // stepKey: enterStoreViewNameCreateCustomStoreView
		$I->fillField("#store_code", "en" . msq("customStoreEN")); // stepKey: enterStoreViewCodeCreateCustomStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateCustomStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateCustomStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateCustomStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateCustomStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateCustomStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateCustomStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateCustomStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateCustomStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateCustomStoreView
		$I->comment("Exiting Action Group [createCustomStoreView] AdminCreateStoreViewActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$setEnableBackupToNo = $I->magentoCLI("config:set system/backup/functionality_enabled 0", 60); // stepKey: setEnableBackupToNo
		$I->comment($setEnableBackupToNo);
		$I->deleteEntity("rootCategory", "hook"); // stepKey: deleteRootCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
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
	 * @Stories({"Delete Grid Filter"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Ui"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminGridFilterDeleteAndVerifyErrorMessageTest(AcceptanceTester $I)
	{
		$I->comment("Filter created simple product in grid and add category and website created in create data");
		$I->comment("Entering Action Group [openProductCatalogPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageOpenProductCatalogPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadOpenProductCatalogPage
		$I->comment("Exiting Action Group [openProductCatalogPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [filterProduct] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProduct
		$I->comment("Exiting Action Group [filterProduct] FilterProductGridBySkuActionGroup");
		$I->click(".data-row:nth-of-type(1)"); // stepKey: clickFirstRowOfCreatedSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickFirstRowOfCreatedSimpleProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitUntilProductIsOpened
		$I->comment("Entering Action Group [updateSimpleProductAddingWebsiteCreated] AddWebsiteToProductActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToProductInWebsiteSectionHeaderUpdateSimpleProductAddingWebsiteCreated
		$I->waitForPageLoad(30); // stepKey: scrollToProductInWebsiteSectionHeaderUpdateSimpleProductAddingWebsiteCreatedWaitForPageLoad
		$I->click("div[data-index='websites']"); // stepKey: clickProductInWebsiteSectionHeaderUpdateSimpleProductAddingWebsiteCreated
		$I->waitForPageLoad(30); // stepKey: clickProductInWebsiteSectionHeaderUpdateSimpleProductAddingWebsiteCreatedWaitForPageLoad
		$I->checkOption("//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: checkWebsiteUpdateSimpleProductAddingWebsiteCreated
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfAdminProductFormSectionUpdateSimpleProductAddingWebsiteCreated
		$I->click("#save-button"); // stepKey: clickSaveButtonUpdateSimpleProductAddingWebsiteCreated
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonUpdateSimpleProductAddingWebsiteCreatedWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSimpleProductSavedUpdateSimpleProductAddingWebsiteCreated
		$I->see("You saved the product.", "#messages"); // stepKey: seeAssertProductSaveSuccessMessageUpdateSimpleProductAddingWebsiteCreated
		$I->comment("Exiting Action Group [updateSimpleProductAddingWebsiteCreated] AddWebsiteToProductActionGroup");
		$I->comment("Search updated simple product(from above step) in the grid by StoreView and Name");
		$I->comment("Entering Action Group [searchCreatedSimpleProductInGrid] FilterProductInGridByStoreViewAndNameActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: OpenProductCatalogPageToSearchProductSearchCreatedSimpleProductInGrid
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageToLoadSearchCreatedSimpleProductInGrid
		$I->conditionalClick(".admin__data-grid-header .admin__data-grid-filters-current._show .action-clear", ".admin__data-grid-header .admin__data-grid-filters-current._show .action-clear", true); // stepKey: clickClearAllSearchCreatedSimpleProductInGrid
		$I->waitForPageLoad(30); // stepKey: clickClearAllSearchCreatedSimpleProductInGridWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFiltersButtonSearchCreatedSimpleProductInGrid
		$I->click("//select[@name='store_id']/option[contains(.,'EN" . msq("customStoreEN") . "')]"); // stepKey: clickStoreViewDropdownSearchCreatedSimpleProductInGrid
		$I->fillField("input.admin__control-text[name='name']", $I->retrieveEntityField('createProduct', 'name', 'test')); // stepKey: fillProductNameInNameFilterSearchCreatedSimpleProductInGrid
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonSearchCreatedSimpleProductInGrid
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchCreatedSimpleProductInGridWaitForPageLoad
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), ".data-row:nth-of-type(1)"); // stepKey: seeFirstRowToVerifyProductVisibleInGridSearchCreatedSimpleProductInGrid
		$I->waitForPageLoad(30); // stepKey: seeFirstRowToVerifyProductVisibleInGridSearchCreatedSimpleProductInGridWaitForPageLoad
		$I->comment("Exiting Action Group [searchCreatedSimpleProductInGrid] FilterProductInGridByStoreViewAndNameActionGroup");
		$I->comment("Go to stores and delete website created in create data");
		$I->comment("Entering Action Group [deleteWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "Second Website" . msq("customWebsite")); // stepKey: fillSearchWebsiteFieldDeleteWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteWebsiteWaitForPageLoad
		$I->see("Second Website" . msq("customWebsite"), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteWebsite
		$I->click("tr:nth-of-type(1) > .col-website_title > a"); // stepKey: clickEditExistingStoreRowDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteStoreGroupSectionLoadDeleteWebsite
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonDeleteWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadDeleteWebsite
		$I->see("You deleted the website."); // stepKey: seeSavedMessageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilter2DeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilter2DeleteWebsiteWaitForPageLoad
		$I->comment("Exiting Action Group [deleteWebsite] AdminDeleteWebsiteActionGroup");
		$I->comment("Go to grid page and verify AssertErrorMessage");
		$I->comment("Entering Action Group [verifyErrorMessage] AssertErrorMessageAfterDeletingWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: OpenProductCatalogPageVerifyErrorMessage
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageLoadVerifyErrorMessage
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: clickOkButtonFromAdminCategoryModalSectionVerifyErrorMessage
		$I->see("Something went wrong with processing the default view and we have restored the filter to its original state.", "//div[@class='message message-error error']"); // stepKey: seeAssertErrorMessageVerifyErrorMessage
		$I->comment("Exiting Action Group [verifyErrorMessage] AssertErrorMessageAfterDeletingWebsiteActionGroup");
	}
}
