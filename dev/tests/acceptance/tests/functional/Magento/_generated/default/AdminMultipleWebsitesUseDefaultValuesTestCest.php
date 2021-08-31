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
 * @Title("MC-25783: Use Default Value checkboxes should be checked for new website scope")
 * @Description("Use Default Value checkboxes for product attribute should be checked for new website scope<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminMultipleWebsitesUseDefaultValuesTest.xml<br>")
 * @TestCaseId("MC-25783")
 * @group Catalog
 */
class AdminMultipleWebsitesUseDefaultValuesTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [createAdditionalWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageCreateAdditionalWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadCreateAdditionalWebsite
		$I->comment("Create Website");
		$I->fillField("#website_name", "Second Website" . msq("customWebsite")); // stepKey: enterWebsiteNameCreateAdditionalWebsite
		$I->fillField("#website_code", "second_website" . msq("customWebsite")); // stepKey: enterWebsiteCodeCreateAdditionalWebsite
		$I->click("#save"); // stepKey: clickSaveWebsiteCreateAdditionalWebsite
		$I->waitForPageLoad(60); // stepKey: clickSaveWebsiteCreateAdditionalWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadCreateAdditionalWebsite
		$I->see("You saved the website."); // stepKey: seeSavedMessageCreateAdditionalWebsite
		$I->comment("Exiting Action Group [createAdditionalWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Entering Action Group [createNewStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateNewStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateNewStore
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Second Website" . msq("customWebsite")); // stepKey: selectWebsiteCreateNewStore
		$I->fillField("#group_name", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupNameCreateNewStore
		$I->fillField("#group_code", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupCodeCreateNewStore
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateNewStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateNewStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateNewStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateNewStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateNewStore
		$I->comment("Exiting Action Group [createNewStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Entering Action Group [createNewStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateNewStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateNewStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStoreGroup")); // stepKey: selectStoreCreateNewStoreView
		$I->fillField("#store_name", "store" . msq("customStore")); // stepKey: enterStoreViewNameCreateNewStoreView
		$I->fillField("#store_code", "store" . msq("customStore")); // stepKey: enterStoreViewCodeCreateNewStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateNewStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateNewStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateNewStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateNewStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateNewStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateNewStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateNewStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateNewStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateNewStoreView
		$I->comment("Exiting Action Group [createNewStoreView] AdminCreateStoreViewActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteSecondWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteSecondWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteSecondWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "Second Website" . msq("customWebsite")); // stepKey: fillSearchWebsiteFieldDeleteSecondWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteSecondWebsiteWaitForPageLoad
		$I->see("Second Website" . msq("customWebsite"), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteSecondWebsite
		$I->click("tr:nth-of-type(1) > .col-website_title > a"); // stepKey: clickEditExistingStoreRowDeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteSecondWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteSecondWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteStoreGroupSectionLoadDeleteSecondWebsite
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteSecondWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonDeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonDeleteSecondWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadDeleteSecondWebsite
		$I->see("You deleted the website."); // stepKey: seeSavedMessageDeleteSecondWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilter2DeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilter2DeleteSecondWebsiteWaitForPageLoad
		$I->comment("Exiting Action Group [deleteSecondWebsite] AdminDeleteWebsiteActionGroup");
		$I->comment("Entering Action Group [clearFilters] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearFilters
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearFilters
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFilters
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilters] AdminClearFiltersActionGroup");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Stories({"Create websites"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMultipleWebsitesUseDefaultValuesTest(AcceptanceTester $I)
	{
		$I->comment("Create a Simple Product");
		$I->comment("Entering Action Group [navigateToCatalogProductGrid] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToCatalogProductGrid
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToCatalogProductGrid
		$I->comment("Exiting Action Group [navigateToCatalogProductGrid] AdminOpenProductIndexPageActionGroup");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [clickAddSimpleProduct] AdminClickAddProductToggleAndSelectProductTypeActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownClickAddSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownClickAddSimpleProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-simple']"); // stepKey: clickAddProductClickAddSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadClickAddSimpleProduct
		$I->comment("Exiting Action Group [clickAddSimpleProduct] AdminClickAddProductToggleAndSelectProductTypeActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: fillProductName
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: fillProductSKU
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPrice
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQuantity
		$I->comment("Add product to second website and save the product");
		$I->click("div[data-index='websites']"); // stepKey: openProductInWebsites
		$I->waitForPageLoad(30); // stepKey: openProductInWebsitesWaitForPageLoad
		$I->click("//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectSecondWebsite
		$I->click("#save-button"); // stepKey: clickSave
		$I->waitForPageLoad(30); // stepKey: clickSaveWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForProductPageSave
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveProductMessage
		$I->comment("switch to the second store view");
		$I->click("#store-change-button"); // stepKey: clickStoreviewSwitcher
		$I->waitForPageLoad(10); // stepKey: clickStoreviewSwitcherWaitForPageLoad
		$I->click("//ul[@data-role='stores-list']/li/a[normalize-space(.)='store" . msq("customStore") . "']"); // stepKey: chooseStoreView
		$I->waitForPageLoad(10); // stepKey: chooseStoreViewWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptStoreSwitchingMessage
		$I->waitForPageLoad(60); // stepKey: acceptStoreSwitchingMessageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad9
		$I->see("store" . msq("customStore"), ".store-switcher"); // stepKey: seeNewStoreViewName
		$I->comment("Check if Use Default Value checkboxes are checked");
		$I->seeCheckboxIsChecked("input[name='use_default[status]']"); // stepKey: seeProductStatusCheckboxChecked
		$I->seeCheckboxIsChecked("input[name='use_default[name]']"); // stepKey: seeProductNameCheckboxChecked
		$I->seeCheckboxIsChecked("input[name='use_default[tax_class_id]']"); // stepKey: seeTaxClassCheckboxChecked
		$I->seeCheckboxIsChecked("//input[@name='use_default[visibility]']"); // stepKey: seeVisibilityCheckboxChecked
	}
}
