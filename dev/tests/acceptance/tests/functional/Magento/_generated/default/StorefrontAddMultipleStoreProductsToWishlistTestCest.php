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
 * @Title("MC-6243: Customer should be able to add products to wishlist from different stores")
 * @Description("All products added to wishlist should be visible on any store. Even if product visibility was set to 'Not Visible Individually' for this store<h3>Test files</h3>app/code/Magento/Wishlist/Test/Mftf/Test/StorefrontAddMultipleStoreProductsToWishlistTest.xml<br>")
 * @group wishlist
 * @TestCaseId("MC-6243")
 */
class StorefrontAddMultipleStoreProductsToWishlistTestCest
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
        $this->helperContainer->create("Magento\Tax\Test\Mftf\Helper\TaxHelpers");
        $this->helperContainer->create("Magento\Backend\Test\Mftf\Helper\CurlHelpers");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("storeGroup", "hook", "customStoreGroup", [], []); // stepKey: storeGroup
		$I->createEntity("categoryHandle", "hook", "SimpleSubCategory", [], []); // stepKey: categoryHandle
		$I->createEntity("product", "hook", "SimpleProduct", ["categoryHandle"], []); // stepKey: product
		$I->createEntity("secondProduct", "hook", "SimpleProduct", ["categoryHandle"], []); // stepKey: secondProduct
		$I->createEntity("customer", "hook", "Simple_US_Customer", [], []); // stepKey: customer
		$I->comment("Create new store view and assign it to non default store");
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->comment("Entering Action Group [createCustomStoreView] CreateCustomStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: amOnAdminSystemStoreViewPageCreateCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadCreateCustomStoreView
		$I->selectOption("#store_group_id", $I->retrieveEntityField('storeGroup', 'group[name]', 'hook')); // stepKey: selectStoreGroupCreateCustomStoreView
		$I->fillField("#store_name", "store" . msq("customStore")); // stepKey: fillStoreViewNameCreateCustomStoreView
		$I->fillField("#store_code", "store" . msq("customStore")); // stepKey: fillStoreViewCodeCreateCustomStoreView
		$I->selectOption("#store_is_active", "1"); // stepKey: selectStoreViewStatusCreateCustomStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewButtonCreateCustomStoreView
		$I->waitForPageLoad(90); // stepKey: clickSaveStoreViewButtonCreateCustomStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2CreateCustomStoreView
		$I->conditionalClick(".action-primary.action-accept", ".action-primary.action-accept", true); // stepKey: clickAcceptNewStoreViewCreationButtonCreateCustomStoreView
		$I->comment("Exiting Action Group [createCustomStoreView] CreateCustomStoreViewActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Logout customer");
		$I->comment("Entering Action Group [logoutStorefront] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutStorefront
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutStorefront
		$I->comment("Exiting Action Group [logoutStorefront] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("product", "hook"); // stepKey: deleteFirstProduct
		$I->deleteEntity("secondProduct", "hook"); // stepKey: deleteSecondProduct
		$I->deleteEntity("customer", "hook"); // stepKey: deleteCustomer
		$I->comment("Entering Action Group [deleteCustomStoreGroup] DeleteCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteCustomStoreGroup
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteCustomStoreGroupWaitForPageLoad
		$I->fillField("#storeGrid_filter_group_title", $I->retrieveEntityField('storeGroup', 'group[name]', 'hook')); // stepKey: fillSearchStoreGroupFieldDeleteCustomStoreGroup
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteCustomStoreGroupWaitForPageLoad
		$I->see($I->retrieveEntityField('storeGroup', 'group[name]', 'hook'), ".col-group_title>a"); // stepKey: verifyThatCorrectStoreGroupFoundDeleteCustomStoreGroup
		$I->click(".col-group_title>a"); // stepKey: clickEditExistingStoreRowDeleteCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteCustomStoreGroup
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteCustomStoreGroupWaitForPageLoad
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteCustomStoreGroup
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteCustomStoreGroupWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteCustomStoreGroup
		$I->see("You deleted the store.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCustomStoreGroup
		$I->comment("Exiting Action Group [deleteCustomStoreGroup] DeleteCustomStoreActionGroup");
		$I->comment("Entering Action Group [clearWebsitesGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearWebsitesGridFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearWebsitesGridFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearWebsitesGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Clear products filter");
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [clearProductsFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearProductsFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearProductsFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductsFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Logout everywhere");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
		$I->comment("BIC workaround");
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
	 * @Features({"Wishlist"})
	 * @Stories({"Add product to wishlist"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontAddMultipleStoreProductsToWishlistTest(AcceptanceTester $I)
	{
		$I->comment("Change products visibility on store-view level");
		$I->comment("Entering Action Group [searchForProduct1] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForProduct1
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForProduct1
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForProduct1
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForProduct1
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForProduct1WaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('product', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchForProduct1
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForProduct1
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForProduct1WaitForPageLoad
		$I->comment("Exiting Action Group [searchForProduct1] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [openEditProduct1] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('product', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProduct1
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct1
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('product', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct1
		$I->comment("Exiting Action Group [openEditProduct1] OpenEditProductOnBackendActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopToChangeStore
		$I->click("#store-change-button"); // stepKey: clickSwitchStoreMenuForProduct1
		$I->waitForPageLoad(10); // stepKey: clickSwitchStoreMenuForProduct1WaitForPageLoad
		$I->waitForElementVisible("//a[contains(text(),'store" . msq("customStore") . "')]", 30); // stepKey: waitCustomStoreItemAppers
		$I->click("//a[contains(text(),'store" . msq("customStore") . "')]"); // stepKey: clickOnStoreNameItemForProduct1
		$I->waitForElementVisible("button[class='action-primary action-accept']", 30); // stepKey: waitAcceptStoreSwitchingForProduct1n
		$I->waitForPageLoad(30); // stepKey: waitAcceptStoreSwitchingForProduct1nWaitForPageLoad
		$I->click("button[class='action-primary action-accept']"); // stepKey: acceptStoreSwitchingForProduct1
		$I->waitForPageLoad(30); // stepKey: acceptStoreSwitchingForProduct1WaitForPageLoad
		$I->click("//input[@name='use_default[visibility]']"); // stepKey: uncheckVisibilityUseDefaultValueForProduct1
		$I->selectOption("//select[@name='product[visibility]']", "Not Visible Individually"); // stepKey: makeProductNotVisibleOnSecondaryStoreView
		$I->comment("Entering Action Group [saveEditedProductForProduct1] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductSaveEditedProductForProduct1
		$I->waitForPageLoad(30); // stepKey: saveProductSaveEditedProductForProduct1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingSaveEditedProductForProduct1
		$I->comment("Exiting Action Group [saveEditedProductForProduct1] AdminProductFormSaveActionGroup");
		$I->comment("Entering Action Group [searchForProduct2] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForProduct2
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForProduct2
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForProduct2
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForProduct2
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForProduct2WaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('secondProduct', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchForProduct2
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForProduct2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForProduct2WaitForPageLoad
		$I->comment("Exiting Action Group [searchForProduct2] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [openEditProduct2] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('secondProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProduct2
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct2
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('secondProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct2
		$I->comment("Exiting Action Group [openEditProduct2] OpenEditProductOnBackendActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopToChangeStoreAgain
		$I->click("#store-change-button"); // stepKey: clickSwitchStoreMenuForProduct2
		$I->waitForPageLoad(10); // stepKey: clickSwitchStoreMenuForProduct2WaitForPageLoad
		$I->waitForElementVisible("//a[contains(text(),'store" . msq("customStore") . "')]", 30); // stepKey: waitDefaultStoreItemAppers
		$I->click("//a[contains(text(),'Default Store View')]"); // stepKey: clickOnStoreNameItemForProduct2
		$I->waitForElementVisible("button[class='action-primary action-accept']", 30); // stepKey: waitAcceptStoreSwitchingForProduct2
		$I->waitForPageLoad(30); // stepKey: waitAcceptStoreSwitchingForProduct2WaitForPageLoad
		$I->click("button[class='action-primary action-accept']"); // stepKey: acceptStoreSwitchingForProduct2
		$I->waitForPageLoad(30); // stepKey: acceptStoreSwitchingForProduct2WaitForPageLoad
		$I->click("//input[@name='use_default[visibility]']"); // stepKey: uncheckVisibilityUseDefaultValueForProduct2
		$I->selectOption("//select[@name='product[visibility]']", "Not Visible Individually"); // stepKey: makeProductNotVisibleOnDefaultStoreView
		$I->comment("Entering Action Group [saveEditedProductForProduct2] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductSaveEditedProductForProduct2
		$I->waitForPageLoad(30); // stepKey: saveProductSaveEditedProductForProduct2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingSaveEditedProductForProduct2
		$I->comment("Exiting Action Group [saveEditedProductForProduct2] AdminProductFormSaveActionGroup");
		$I->comment("Sign in as customer");
		$I->comment("Entering Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerLogin
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerLogin
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerLogin
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailCustomerLogin
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test')); // stepKey: fillPasswordCustomerLogin
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerLogin
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerLoginWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerLogin
		$I->comment("Exiting Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->see($I->retrieveEntityField('customer', 'firstname', 'test'), ".box.box-information .box-content"); // stepKey: seeFirstName
		$I->see($I->retrieveEntityField('customer', 'lastname', 'test'), ".box.box-information .box-content"); // stepKey: seeLastName
		$I->see($I->retrieveEntityField('customer', 'email', 'test'), ".box.box-information .box-content"); // stepKey: seeEmail
		$I->comment("Add product visible on default store to wishlist");
		$I->amOnPage("/" . $I->retrieveEntityField('product', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOnDefaultStore
		$I->see($I->retrieveEntityField('product', 'name', 'test'), ".base"); // stepKey: assertFirstProductNameTitle
		$I->click("//a[@class='action towishlist']"); // stepKey: addFirstProductToWishlist
		$I->waitForPageLoad(30); // stepKey: addFirstProductToWishlistWaitForPageLoad
		$I->comment("Switch to second store and add second product (visible on second store) to wishlist");
		$I->click("#switcher-store-trigger"); // stepKey: clickSwitchStoreButtonOnDefaultStore
		$I->click("//ul[@class='dropdown switcher-dropdown']//a[contains(text(),'" . $I->retrieveEntityField('storeGroup', 'group[name]', 'test') . "')]"); // stepKey: selectSecondStoreToSwitchOn
		$I->waitForPageLoad(30); // stepKey: selectSecondStoreToSwitchOnWaitForPageLoad
		$I->comment("Verify that both products are visible in wishlist on both stores");
		$I->amOnPage("/" . $I->retrieveEntityField('secondProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOnSecondStore
		$I->see($I->retrieveEntityField('secondProduct', 'name', 'test'), ".base"); // stepKey: assertSecondProductNameTitle
		$I->click("//a[@class='action towishlist']"); // stepKey: addSecondProductToWishlist
		$I->waitForPageLoad(30); // stepKey: addSecondProductToWishlistWaitForPageLoad
		$I->see($I->retrieveEntityField('secondProduct', 'name', 'test'), ".products-grid .product-item-name a"); // stepKey: seeProduct2InWishlistOnSecondStore
		$I->click("#switcher-store-trigger"); // stepKey: clickSwitchStoreButtonOnSecondStore
		$I->click("//ul[@class='dropdown switcher-dropdown']//a[contains(text(),'Main Website Store')]"); // stepKey: selectDefaultStoreToSwitchOn
		$I->waitForPageLoad(30); // stepKey: selectDefaultStoreToSwitchOnWaitForPageLoad
		$I->see($I->retrieveEntityField('product', 'name', 'test'), ".products-grid .product-item-name a"); // stepKey: seeProduct1InWishlistOnDefaultStore
	}
}
