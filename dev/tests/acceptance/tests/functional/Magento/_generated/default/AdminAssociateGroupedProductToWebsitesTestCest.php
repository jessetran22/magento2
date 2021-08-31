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
 * @Title("MC-3377: Admin should be able to associate grouped product to websites")
 * @Description("Admin should be able to associate grouped product to websites<h3>Test files</h3>app/code/Magento/GroupedProduct/Test/Mftf/Test/AdminAssociateGroupedProductToWebsitesTest.xml<br>")
 * @TestCaseId("MC-3377")
 * @group catalog
 * @group groupedProduct
 */
class AdminAssociateGroupedProductToWebsitesTestCest
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
		$I->comment("Set Store Code To Urls");
		$setAddStoreCodeToUrlsToYes = $I->magentoCLI("config:set web/url/use_store 1", 60); // stepKey: setAddStoreCodeToUrlsToYes
		$I->comment($setAddStoreCodeToUrlsToYes);
		$I->comment("Create grouped product");
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProduct
		$I->createEntity("createGroupedProduct", "hook", "ApiGroupedProduct", [], []); // stepKey: createGroupedProduct
		$I->createEntity("addProductOne", "hook", "OneSimpleProductLink", ["createGroupedProduct", "createSimpleProduct"], []); // stepKey: addProductOne
		$I->comment("Login as Admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create website");
		$I->comment("Entering Action Group [createSecondWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageCreateSecondWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadCreateSecondWebsite
		$I->comment("Create Website");
		$I->fillField("#website_name", "Custom Website" . msq("secondCustomWebsite")); // stepKey: enterWebsiteNameCreateSecondWebsite
		$I->fillField("#website_code", "custom_website" . msq("secondCustomWebsite")); // stepKey: enterWebsiteCodeCreateSecondWebsite
		$I->click("#save"); // stepKey: clickSaveWebsiteCreateSecondWebsite
		$I->waitForPageLoad(60); // stepKey: clickSaveWebsiteCreateSecondWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadCreateSecondWebsite
		$I->see("You saved the website."); // stepKey: seeSavedMessageCreateSecondWebsite
		$I->comment("Exiting Action Group [createSecondWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Create second store");
		$I->comment("Entering Action Group [createSecondStoreGroup] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateSecondStoreGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateSecondStoreGroup
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Custom Website" . msq("secondCustomWebsite")); // stepKey: selectWebsiteCreateSecondStoreGroup
		$I->fillField("#group_name", "Second Store " . msq("SecondStoreGroupUnique")); // stepKey: enterStoreGroupNameCreateSecondStoreGroup
		$I->fillField("#group_code", "second_store_" . msq("SecondStoreGroupUnique")); // stepKey: enterStoreGroupCodeCreateSecondStoreGroup
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateSecondStoreGroup
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateSecondStoreGroup
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateSecondStoreGroupWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateSecondStoreGroup
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateSecondStoreGroup
		$I->comment("Exiting Action Group [createSecondStoreGroup] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Create second store view");
		$I->comment("Entering Action Group [createSecondStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateSecondStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateSecondStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Second Store " . msq("SecondStoreGroupUnique")); // stepKey: selectStoreCreateSecondStoreView
		$I->fillField("#store_name", "Second Store View " . msq("SecondStoreUnique")); // stepKey: enterStoreViewNameCreateSecondStoreView
		$I->fillField("#store_code", "second_store_view_" . msq("SecondStoreUnique")); // stepKey: enterStoreViewCodeCreateSecondStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateSecondStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateSecondStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateSecondStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateSecondStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateSecondStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateSecondStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateSecondStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateSecondStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateSecondStoreView
		$I->comment("Exiting Action Group [createSecondStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Disable Store Code To Urls");
		$setAddStoreCodeToUrlsToNo = $I->magentoCLI("config:set web/url/use_store 0", 60); // stepKey: setAddStoreCodeToUrlsToNo
		$I->comment($setAddStoreCodeToUrlsToNo);
		$I->comment("Delete product data");
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createGroupedProduct", "hook"); // stepKey: deleteGroupedProduct
		$I->comment("Delete second website");
		$I->comment("Entering Action Group [deleteWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "Custom Website" . msq("secondCustomWebsite")); // stepKey: fillSearchWebsiteFieldDeleteWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteWebsiteWaitForPageLoad
		$I->see("Custom Website" . msq("secondCustomWebsite"), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteWebsite
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
		$I->comment("Entering Action Group [resetProductGridFilter] NavigateToAndResetProductGridToDefaultViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToAdminProductIndexPageResetProductGridFilter
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadResetProductGridFilter
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetProductGridFilter
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetProductGridFilterWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetProductGridFilter
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetProductGridFilter
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetProductGridFilterWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetProductGridFilter
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetProductGridFilter
		$I->comment("Exiting Action Group [resetProductGridFilter] NavigateToAndResetProductGridToDefaultViewActionGroup");
		$I->comment("Admin logout");
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
	 * @Features({"GroupedProduct"})
	 * @Stories({"Create/Edit grouped product in Admin"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAssociateGroupedProductToWebsitesTest(AcceptanceTester $I)
	{
		$I->comment("Open product page and assign grouped project to second website");
		$I->comment("Entering Action Group [openAdminProductPage] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageOpenAdminProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadOpenAdminProductPage
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersOpenAdminProductPage
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersOpenAdminProductPageWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersOpenAdminProductPage
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createGroupedProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterOpenAdminProductPage
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersOpenAdminProductPage
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersOpenAdminProductPageWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadOpenAdminProductPage
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createGroupedProduct', 'sku', 'test') . "']]"); // stepKey: openSelectedProductOpenAdminProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadOpenAdminProductPage
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleOpenAdminProductPage
		$I->comment("Exiting Action Group [openAdminProductPage] FilterAndSelectProductActionGroup");
		$I->comment("Entering Action Group [assignProductToSecondWebsite] AdminAssignProductInWebsiteActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToWebsitesSectionAssignProductToSecondWebsite
		$I->waitForPageLoad(30); // stepKey: scrollToWebsitesSectionAssignProductToSecondWebsiteWaitForPageLoad
		$I->click("div[data-index='websites']"); // stepKey: expandSectionAssignProductToSecondWebsite
		$I->waitForPageLoad(30); // stepKey: expandSectionAssignProductToSecondWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageOpenedAssignProductToSecondWebsite
		$I->checkOption("//label[contains(text(), 'Custom Website" . msq("secondCustomWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectWebsiteAssignProductToSecondWebsite
		$I->comment("Exiting Action Group [assignProductToSecondWebsite] AdminAssignProductInWebsiteActionGroup");
		$I->comment("Entering Action Group [unassignProductFromDefaultWebsite] AdminUnassignProductInWebsiteActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToWebsitesSectionUnassignProductFromDefaultWebsite
		$I->waitForPageLoad(30); // stepKey: scrollToWebsitesSectionUnassignProductFromDefaultWebsiteWaitForPageLoad
		$I->click("div[data-index='websites']"); // stepKey: expandSectionUnassignProductFromDefaultWebsite
		$I->waitForPageLoad(30); // stepKey: expandSectionUnassignProductFromDefaultWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageOpenedUnassignProductFromDefaultWebsite
		$I->uncheckOption("//label[contains(text(), 'Main Website')]/parent::div//input[@type='checkbox']"); // stepKey: uncheckWebsiteUnassignProductFromDefaultWebsite
		$I->comment("Exiting Action Group [unassignProductFromDefaultWebsite] AdminUnassignProductInWebsiteActionGroup");
		$I->comment("Entering Action Group [saveGroupedProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveGroupedProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveGroupedProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveGroupedProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveGroupedProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveGroupedProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveGroupedProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveGroupedProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveGroupedProduct
		$I->comment("Exiting Action Group [saveGroupedProduct] SaveProductFormActionGroup");
		$I->comment("Assert product is assigned to Second website");
		$I->comment("Entering Action Group [seeCustomWebsiteIsChecked] AssertProductIsAssignedToWebsiteActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToProductInWebsitesSectionSeeCustomWebsiteIsChecked
		$I->waitForPageLoad(30); // stepKey: scrollToProductInWebsitesSectionSeeCustomWebsiteIsCheckedWaitForPageLoad
		$I->conditionalClick("div[data-index='websites']", "[data-index='websites']._show", false); // stepKey: expandProductWebsitesSectionSeeCustomWebsiteIsChecked
		$I->waitForPageLoad(30); // stepKey: expandProductWebsitesSectionSeeCustomWebsiteIsCheckedWaitForPageLoad
		$I->seeCheckboxIsChecked("//label[contains(text(), 'Custom Website" . msq("secondCustomWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: seeCustomWebsiteIsCheckedSeeCustomWebsiteIsChecked
		$I->comment("Exiting Action Group [seeCustomWebsiteIsChecked] AssertProductIsAssignedToWebsiteActionGroup");
		$I->comment("Assert product is not assigned to Main website");
		$I->comment("Entering Action Group [seeMainWebsiteIsNotChecked] AssertProductIsNotAssignedToWebsiteActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToProductInWebsitesSectionSeeMainWebsiteIsNotChecked
		$I->waitForPageLoad(30); // stepKey: scrollToProductInWebsitesSectionSeeMainWebsiteIsNotCheckedWaitForPageLoad
		$I->conditionalClick("div[data-index='websites']", "[data-index='websites']._show", false); // stepKey: expandProductWebsitesSectionSeeMainWebsiteIsNotChecked
		$I->waitForPageLoad(30); // stepKey: expandProductWebsitesSectionSeeMainWebsiteIsNotCheckedWaitForPageLoad
		$I->dontSeeCheckboxIsChecked("//label[contains(text(), 'Main Website')]/parent::div//input[@type='checkbox']"); // stepKey: seeCustomWebsiteIsNotCheckedSeeMainWebsiteIsNotChecked
		$I->comment("Exiting Action Group [seeMainWebsiteIsNotChecked] AssertProductIsNotAssignedToWebsiteActionGroup");
		$I->comment("Go to frontend and open product on Main website");
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createGroupedProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Assert 404 page");
		$I->comment("Entering Action Group [assertPageNotFoundErrorOnProductDetailPage] StorefrontAssertPageNotFoundErrorOnProductDetailPageActionGroup");
		$I->see("Whoops, our bad...", ".base"); // stepKey: assert404PageAssertPageNotFoundErrorOnProductDetailPage
		$I->dontSee($I->retrieveEntityField('createGroupedProduct', 'name', 'test'), ".base"); // stepKey: dontSeeProductNameAssertPageNotFoundErrorOnProductDetailPage
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createGroupedProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkProductUrlAssertPageNotFoundErrorOnProductDetailPage
		$I->comment("Exiting Action Group [assertPageNotFoundErrorOnProductDetailPage] StorefrontAssertPageNotFoundErrorOnProductDetailPageActionGroup");
		$I->comment("Assert grouped product on Second website");
		$I->comment("Entering Action Group [openProductPageUsingStoreCodeInUrl] StorefrontOpenProductPageUsingStoreCodeInUrlActionGroup");
		$I->amOnPage("/second_store_view_" . msq("SecondStoreUnique") . "/" . $I->retrieveEntityField('createGroupedProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageUsingStoreCodeInUrlOpenProductPageUsingStoreCodeInUrl
		$I->see($I->retrieveEntityField('createGroupedProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProductPageUsingStoreCodeInUrl
		$I->comment("Exiting Action Group [openProductPageUsingStoreCodeInUrl] StorefrontOpenProductPageUsingStoreCodeInUrlActionGroup");
	}
}
