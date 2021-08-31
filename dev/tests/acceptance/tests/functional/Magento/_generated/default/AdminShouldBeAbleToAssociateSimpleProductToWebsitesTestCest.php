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
 * @Title("MC-3483: Admin should be able to associate simple product to websites")
 * @Description("Admin should be able to associate simple product to websites<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminShouldBeAbleToAssociateSimpleProductToWebsitesTest.xml<br>")
 * @TestCaseId("MC-3483")
 * @group catalog
 */
class AdminShouldBeAbleToAssociateSimpleProductToWebsitesTestCest
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
		$setAddStoreCodeToUrlsToYes = $I->magentoCLI("config:set web/url/use_store 1", 60); // stepKey: setAddStoreCodeToUrlsToYes
		$I->comment($setAddStoreCodeToUrlsToYes);
		$I->createEntity("createCustomWebsite", "hook", "secondCustomWebsite", [], []); // stepKey: createCustomWebsite
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
		$I->comment("Entering Action Group [createNewStore] AdminStoreGroupCreateActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreGroupCreateNewStore
		$I->waitForPageLoad(30); // stepKey: waitForStoreGroupPageLoadCreateNewStore
		$I->comment("Creating Store Group");
		$I->selectOption("#group_website_id", "Custom Website" . msq("secondCustomWebsite")); // stepKey: selectWebsiteCreateNewStore
		$I->fillField("#group_name", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupNameCreateNewStore
		$I->fillField("#group_code", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupCodeCreateNewStore
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: setRootCategoryCreateNewStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateNewStore
		$I->waitForPageLoad(30); // stepKey: clickSaveStoreGroupCreateNewStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_store_title", 30); // stepKey: waitForPageReloadCreateNewStore
		$I->waitForPageLoad(90); // stepKey: waitForPageReloadCreateNewStoreWaitForPageLoad
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateNewStore
		$I->comment("Exiting Action Group [createNewStore] AdminStoreGroupCreateActionGroup");
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
		$setAddStoreCodeToUrlsToNo = $I->magentoCLI("config:set web/url/use_store 0", 60); // stepKey: setAddStoreCodeToUrlsToNo
		$I->comment($setAddStoreCodeToUrlsToNo);
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Delete second website");
		$I->comment("Entering Action Group [deleteCustomWeWebsite] DeleteCustomWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnTheStorePageDeleteCustomWeWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: clickOnResetButtonDeleteCustomWeWebsite
		$I->waitForPageLoad(30); // stepKey: clickOnResetButtonDeleteCustomWeWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", $I->retrieveEntityField('createCustomWebsite', 'website[name]', 'hook')); // stepKey: fillSearchWebsiteFieldDeleteCustomWeWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteCustomWeWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteCustomWeWebsiteWaitForPageLoad
		$I->see($I->retrieveEntityField('createCustomWebsite', 'website[name]', 'hook'), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteCustomWeWebsite
		$I->click("tr:nth-of-type(1) > .col-website_title > a"); // stepKey: clickEditExistingWebsiteDeleteCustomWeWebsite
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAfterWebsiteSelectedDeleteCustomWeWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonOnEditStorePageDeleteCustomWeWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonOnEditStorePageDeleteCustomWeWebsiteWaitForPageLoad
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteCustomWeWebsite
		$I->click("#delete"); // stepKey: clickDeleteButtonOnDeleteWebsitePageDeleteCustomWeWebsite
		$I->waitForPageLoad(120); // stepKey: clickDeleteButtonOnDeleteWebsitePageDeleteCustomWeWebsiteWaitForPageLoad
		$I->see("You deleted the website.", "#messages div.message-success"); // stepKey: checkSuccessMessageDeleteCustomWeWebsite
		$I->comment("Exiting Action Group [deleteCustomWeWebsite] DeleteCustomWebsiteActionGroup");
		$I->comment("Entering Action Group [resetFiltersOnStoresIndexPage] AdminGridFilterResetActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopResetFiltersOnStoresIndexPage
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersResetFiltersOnStoresIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetResetFiltersOnStoresIndexPage
		$I->comment("Exiting Action Group [resetFiltersOnStoresIndexPage] AdminGridFilterResetActionGroup");
		$I->comment("Entering Action Group [openProductIndexPageToResetFilters] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageOpenProductIndexPageToResetFilters
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadOpenProductIndexPageToResetFilters
		$I->comment("Exiting Action Group [openProductIndexPageToResetFilters] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [clearFiltersOnProductIndexPage] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFiltersOnProductIndexPage
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFiltersOnProductIndexPageWaitForPageLoad
		$I->comment("Exiting Action Group [clearFiltersOnProductIndexPage] ClearFiltersAdminDataGridActionGroup");
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
	 * @Features({"Catalog"})
	 * @Stories({"Edit products"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminShouldBeAbleToAssociateSimpleProductToWebsitesTest(AcceptanceTester $I)
	{
		$I->comment("1. Go to product page in admin panel to edit");
		$I->comment("Entering Action Group [openProductIndexPageToAssociateToSecondWebsite] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageOpenProductIndexPageToAssociateToSecondWebsite
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadOpenProductIndexPageToAssociateToSecondWebsite
		$I->comment("Exiting Action Group [openProductIndexPageToAssociateToSecondWebsite] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [filterProductInGrid] FilterProductGridByName2ActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProductInGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductInGridWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProductInGrid
		$I->fillField("input.admin__control-text[name='name']", $I->retrieveEntityField('createSimpleProduct', 'name', 'test')); // stepKey: fillProductNameFilterFilterProductInGrid
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductInGrid
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductInGridWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductInGrid
		$I->comment("Exiting Action Group [filterProductInGrid] FilterProductGridByName2ActionGroup");
		$I->comment("2. Go to Product in Websites tab, unassign product from Main website and assign it to Second website");
		$I->comment("Entering Action Group [processProductWebsites] AdminProcessProductWebsitesActionGroup");
		$I->click("//div[text()='" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "']"); // stepKey: openProductProcessProductWebsites
		$I->waitForPageLoad(30); // stepKey: waitForProductPageProcessProductWebsites
		$I->scrollTo("div[data-index='websites']"); // stepKey: ScrollToWebsitesProcessProductWebsites
		$I->waitForPageLoad(30); // stepKey: ScrollToWebsitesProcessProductWebsitesWaitForPageLoad
		$I->click("div[data-index='websites']"); // stepKey: openWebsitesListProcessProductWebsites
		$I->waitForPageLoad(30); // stepKey: openWebsitesListProcessProductWebsitesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForWebsitesListProcessProductWebsites
		$I->click("//label[contains(text(), 'Custom Website" . msq("secondCustomWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: SelectWebsiteProcessProductWebsites
		$I->uncheckOption("//label[contains(text(), 'Main Website')]/parent::div//input[@type='checkbox']"); // stepKey: uncheckWebsiteProcessProductWebsites
		$I->click("#save-button"); // stepKey: clickSaveProductProcessProductWebsites
		$I->waitForPageLoad(30); // stepKey: clickSaveProductProcessProductWebsitesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSaveProcessProductWebsites
		$I->comment("Exiting Action Group [processProductWebsites] AdminProcessProductWebsitesActionGroup");
		$I->comment("Entering Action Group [seeCustomWebsiteIsChecked] AssertProductIsAssignedToWebsiteActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToProductInWebsitesSectionSeeCustomWebsiteIsChecked
		$I->waitForPageLoad(30); // stepKey: scrollToProductInWebsitesSectionSeeCustomWebsiteIsCheckedWaitForPageLoad
		$I->conditionalClick("div[data-index='websites']", "[data-index='websites']._show", false); // stepKey: expandProductWebsitesSectionSeeCustomWebsiteIsChecked
		$I->waitForPageLoad(30); // stepKey: expandProductWebsitesSectionSeeCustomWebsiteIsCheckedWaitForPageLoad
		$I->seeCheckboxIsChecked("//label[contains(text(), '" . $I->retrieveEntityField('createCustomWebsite', 'website[name]', 'test') . "')]/parent::div//input[@type='checkbox']"); // stepKey: seeCustomWebsiteIsCheckedSeeCustomWebsiteIsChecked
		$I->comment("Exiting Action Group [seeCustomWebsiteIsChecked] AssertProductIsAssignedToWebsiteActionGroup");
		$I->comment("Entering Action Group [seeMainWebsiteIsNotChecked] AssertProductIsNotAssignedToWebsiteActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToProductInWebsitesSectionSeeMainWebsiteIsNotChecked
		$I->waitForPageLoad(30); // stepKey: scrollToProductInWebsitesSectionSeeMainWebsiteIsNotCheckedWaitForPageLoad
		$I->conditionalClick("div[data-index='websites']", "[data-index='websites']._show", false); // stepKey: expandProductWebsitesSectionSeeMainWebsiteIsNotChecked
		$I->waitForPageLoad(30); // stepKey: expandProductWebsitesSectionSeeMainWebsiteIsNotCheckedWaitForPageLoad
		$I->dontSeeCheckboxIsChecked("//label[contains(text(), 'Main Website')]/parent::div//input[@type='checkbox']"); // stepKey: seeCustomWebsiteIsNotCheckedSeeMainWebsiteIsNotChecked
		$I->comment("Exiting Action Group [seeMainWebsiteIsNotChecked] AssertProductIsNotAssignedToWebsiteActionGroup");
		$I->comment("3. Go to frontend and open Simple product on Main website and assert 404 page");
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [assertPageNotFoundErrorOnProductDetailPage] StorefrontAssertPageNotFoundErrorOnProductDetailPageActionGroup");
		$I->see("Whoops, our bad...", ".base"); // stepKey: assert404PageAssertPageNotFoundErrorOnProductDetailPage
		$I->dontSee($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".base"); // stepKey: dontSeeProductNameAssertPageNotFoundErrorOnProductDetailPage
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkProductUrlAssertPageNotFoundErrorOnProductDetailPage
		$I->comment("Exiting Action Group [assertPageNotFoundErrorOnProductDetailPage] StorefrontAssertPageNotFoundErrorOnProductDetailPageActionGroup");
		$I->comment("4. Open Simple product on Second website and assert its name");
		$I->comment("Entering Action Group [openProductPageUsingStoreCodeInUrl] StorefrontOpenProductPageUsingStoreCodeInUrlActionGroup");
		$I->amOnPage("/en" . msq("customStoreEN") . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageUsingStoreCodeInUrlOpenProductPageUsingStoreCodeInUrl
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProductPageUsingStoreCodeInUrl
		$I->comment("Exiting Action Group [openProductPageUsingStoreCodeInUrl] StorefrontOpenProductPageUsingStoreCodeInUrlActionGroup");
	}
}
