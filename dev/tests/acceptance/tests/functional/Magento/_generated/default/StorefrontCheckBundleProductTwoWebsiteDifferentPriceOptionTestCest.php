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
 * @Title("[NO TESTCASEID]: Verify bundle item price different websites.")
 * @Description("Verify bundle item price different websites. Change bundle item price on second website.<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/StorefrontCheckBundleProductTwoWebsiteDifferentPriceOptionTest.xml<br>")
 * @group bundle
 */
class StorefrontCheckBundleProductTwoWebsiteDifferentPriceOptionTestCest
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
		$setPriceScopeWebsite = $I->magentoCLI("config:set catalog/price/scope 1", 60); // stepKey: setPriceScopeWebsite
		$I->comment($setPriceScopeWebsite);
		$I->comment("Entering Action Group [logInAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogInAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogInAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogInAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogInAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLogInAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogInAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogInAsAdmin
		$I->comment("Exiting Action Group [logInAsAdmin] AdminLoginActionGroup");
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
		$I->comment("Entering Action Group [createCustomStoreGroup] CreateCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageCreateCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: waitForSystemStorePageCreateCustomStoreGroup
		$I->click("#add_group"); // stepKey: selectCreateStoreCreateCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: selectCreateStoreCreateCustomStoreGroupWaitForPageLoad
		$I->selectOption("#group_website_id", "Second Website" . msq("customWebsite")); // stepKey: selectMainWebsiteCreateCustomStoreGroup
		$I->fillField("#group_name", "store" . msq("customStoreGroup")); // stepKey: fillStoreNameCreateCustomStoreGroup
		$I->fillField("#group_code", "store" . msq("customStoreGroup")); // stepKey: fillStoreCodeCreateCustomStoreGroup
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: selectStoreStatusCreateCustomStoreGroup
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateCustomStoreGroup
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateCustomStoreGroupWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateCustomStoreGroup
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateCustomStoreGroup
		$I->comment("Exiting Action Group [createCustomStoreGroup] CreateCustomStoreActionGroup");
		$I->comment("Entering Action Group [createCustomStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateCustomStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStoreGroup")); // stepKey: selectStoreCreateCustomStoreView
		$I->fillField("#store_name", "store" . msq("customStore")); // stepKey: enterStoreViewNameCreateCustomStoreView
		$I->fillField("#store_code", "store" . msq("customStore")); // stepKey: enterStoreViewCodeCreateCustomStoreView
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
		$I->createEntity("simpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct
		$I->createEntity("createBundleProduct", "hook", "ApiFixedBundleProduct", [], []); // stepKey: createBundleProduct
		$I->createEntity("createBundleOption", "hook", "CheckboxOption", ["createBundleProduct"], []); // stepKey: createBundleOption
		$I->createEntity("linkOptionToProduct", "hook", "ApiBundleLinkFixed", ["createBundleProduct", "createBundleOption", "simpleProduct"], []); // stepKey: linkOptionToProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$setPriceScopeGlobal = $I->magentoCLI("config:set catalog/price/scope 0", 60); // stepKey: setPriceScopeGlobal
		$I->comment($setPriceScopeGlobal);
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createBundleProduct", "hook"); // stepKey: deleteBundleProduct
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
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, ""); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
		$I->comment("Entering Action Group [cleanFullPageCache] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanFullPageCache = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanFullPageCache
		$I->comment($cleanSpecifiedCacheCleanFullPageCache);
		$I->comment("Exiting Action Group [cleanFullPageCache] CliCacheCleanActionGroup");
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
	 * @Stories({"Github issue: #12584 Bundle Item price cannot differ per website"})
	 * @Features({"Bundle"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckBundleProductTwoWebsiteDifferentPriceOptionTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openEditBundleProduct] NavigateToCreatedProductEditPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToAdminProductIndexPageOpenEditBundleProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadOpenEditBundleProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersOpenEditBundleProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersOpenEditBundleProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersOpenEditBundleProduct
		$I->dontSeeElement(".admin__data-grid-header button[data-action='grid-filter-reset']"); // stepKey: dontSeeClearFiltersOpenEditBundleProduct
		$I->waitForPageLoad(30); // stepKey: dontSeeClearFiltersOpenEditBundleProductWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabOpenEditBundleProduct
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewOpenEditBundleProduct
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewOpenEditBundleProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForResetToDefaultViewOpenEditBundleProduct
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedOpenEditBundleProduct
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersOpenEditBundleProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createBundleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterOpenEditBundleProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersOpenEditBundleProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersOpenEditBundleProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFilterOnGridOpenEditBundleProduct
		$I->click("//td/div[text()='" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "']"); // stepKey: clickProductOpenEditBundleProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductEditPageLoadOpenEditBundleProduct
		$I->waitForElementVisible("//*[@name='product[sku]']", 30); // stepKey: waitForProductSKUFieldOpenEditBundleProduct
		$I->seeInField("//*[@name='product[sku]']", $I->retrieveEntityField('createBundleProduct', 'sku', 'test')); // stepKey: seeProductSKUOpenEditBundleProduct
		$I->comment("Exiting Action Group [openEditBundleProduct] NavigateToCreatedProductEditPageActionGroup");
		$I->comment("Entering Action Group [selectProductInWebsites] AdminAssignProductInWebsiteActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToWebsitesSectionSelectProductInWebsites
		$I->waitForPageLoad(30); // stepKey: scrollToWebsitesSectionSelectProductInWebsitesWaitForPageLoad
		$I->click("div[data-index='websites']"); // stepKey: expandSectionSelectProductInWebsites
		$I->waitForPageLoad(30); // stepKey: expandSectionSelectProductInWebsitesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageOpenedSelectProductInWebsites
		$I->checkOption("//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectWebsiteSelectProductInWebsites
		$I->comment("Exiting Action Group [selectProductInWebsites] AdminAssignProductInWebsiteActionGroup");
		$I->comment("Entering Action Group [clickSaveButton] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductClickSaveButton
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonClickSaveButton
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonClickSaveButtonWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductClickSaveButton
		$I->waitForPageLoad(30); // stepKey: clickSaveProductClickSaveButtonWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageClickSaveButton
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageClickSaveButton
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] SaveProductFormActionGroup");
		$I->comment("Entering Action Group [SwitchNewStoreView] SwitchToTheNewStoreViewActionGroup");
		$I->scrollTo("//*[@class='page-header row']"); // stepKey: scrollToUpSwitchNewStoreView
		$I->waitForElementVisible("#store-change-button", 30); // stepKey: waitForElementBecomeVisibleSwitchNewStoreView
		$I->waitForPageLoad(10); // stepKey: waitForElementBecomeVisibleSwitchNewStoreViewWaitForPageLoad
		$I->click("#store-change-button"); // stepKey: clickStoreviewSwitcherSwitchNewStoreView
		$I->waitForPageLoad(10); // stepKey: clickStoreviewSwitcherSwitchNewStoreViewWaitForPageLoad
		$I->click("//ul[@data-role='stores-list']/li/a[normalize-space(.)='store" . msq("customStore") . "']"); // stepKey: chooseStoreViewSwitchNewStoreView
		$I->waitForPageLoad(10); // stepKey: chooseStoreViewSwitchNewStoreViewWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptStoreSwitchingMessageSwitchNewStoreView
		$I->waitForPageLoad(60); // stepKey: acceptStoreSwitchingMessageSwitchNewStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchNewStoreView
		$I->comment("Exiting Action Group [SwitchNewStoreView] SwitchToTheNewStoreViewActionGroup");
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][0][selection_price_value]']", "100"); // stepKey: fillBundleOption1Price
		$I->comment("Entering Action Group [saveNewPrice] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveNewPrice
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveNewPrice
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveNewPriceWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveNewPrice
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveNewPriceWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveNewPrice
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveNewPrice
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveNewPrice
		$I->comment("Exiting Action Group [saveNewPrice] SaveProductFormActionGroup");
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createBundleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->click("#bundle-slide"); // stepKey: clickCustomizeAndAddToCart
		$I->waitForPageLoad(30); // stepKey: clickCustomizeAndAddToCartWaitForPageLoad
		$grabPriceText = $I->grabTextFrom("//*[@class='bundle-info']//*[contains(@id,'product-price')]/span"); // stepKey: grabPriceText
		$I->assertEquals("$31.23", $grabPriceText); // stepKey: assertPriceText
	}
}
