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
 * @Title("MAGETWO-94111: Checking 'Tier Pricing' of Products and 'Price' (without discount) in the Order of B2B Store View")
 * @Description("Checking 'Tier Pricing' of Products and 'Price' (without discount) in the Order of B2B Store View<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/CheckTierPricingOfProductsTest.xml<br>")
 * @TestCaseId("MAGETWO-94111")
 * @group Shopping Cart
 */
class CheckTierPricingOfProductsTestCest
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
		$I->createEntity("category", "hook", "_defaultCategory", [], []); // stepKey: category
		$I->createEntity("product1", "hook", "SimpleProduct", ["category"], []); // stepKey: product1
		$I->createEntity("product2", "hook", "SimpleProduct", ["category"], []); // stepKey: product2
		$I->createEntity("product3", "hook", "SimpleProduct", ["category"], []); // stepKey: product3
		$I->createEntity("product4", "hook", "SimpleProduct", ["category"], []); // stepKey: product4
		$I->createEntity("customer", "hook", "Simple_US_Customer", [], []); // stepKey: customer
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("setConfigCustomerAccountToGlobal", "hook", "CustomerAccountSharingGlobal", [], []); // stepKey: setConfigCustomerAccountToGlobal
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("product1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("product2", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("product3", "hook"); // stepKey: deleteProduct3
		$I->deleteEntity("product4", "hook"); // stepKey: deleteProduct4
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("customer", "hook"); // stepKey: deleteCustomer
		$I->createEntity("defaultConfigCatalogPrice", "hook", "DefaultConfigCatalogPrice", [], []); // stepKey: defaultConfigCatalogPrice
		$I->comment("Entering Action Group [cleanUpRule] DeleteCartPriceRuleByName");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListCleanUpRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceListCleanUpRule
		$I->fillField("input[name='name']", "ship"); // stepKey: filterByNameCleanUpRule
		$I->click("#promo_quote_grid button[title='Search']"); // stepKey: doFilterCleanUpRule
		$I->waitForPageLoad(30); // stepKey: doFilterCleanUpRuleWaitForPageLoad
		$I->click("tr[data-role='row']:nth-of-type(1)"); // stepKey: goToEditRulePageCleanUpRule
		$I->waitForPageLoad(30); // stepKey: goToEditRulePageCleanUpRuleWaitForPageLoad
		$I->click("button#delete"); // stepKey: clickDeleteButtonCleanUpRule
		$I->waitForPageLoad(30); // stepKey: clickDeleteButtonCleanUpRuleWaitForPageLoad
		$I->click("button.action-accept"); // stepKey: confirmDeleteCleanUpRule
		$I->waitForPageLoad(30); // stepKey: confirmDeleteCleanUpRuleWaitForPageLoad
		$I->comment("Exiting Action Group [cleanUpRule] DeleteCartPriceRuleByName");
		$I->comment("Entering Action Group [DeleteWebsite] AdminDeleteWebsiteActionGroup");
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
		$I->comment("Exiting Action Group [DeleteWebsite] AdminDeleteWebsiteActionGroup");
		$I->createEntity("setConfigCustomerAccountDefault", "hook", "CustomerAccountSharingDefault", [], []); // stepKey: setConfigCustomerAccountDefault
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
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
	 * @Stories({"MAGETWO-91697 - [Magento Cloud] 'Tier Pricing' of Products changes to 'Price' (without discount) after Updated Items and Quantities in the Order of B2B Store View."})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function CheckTierPricingOfProductsTest(AcceptanceTester $I)
	{
		$I->comment("Create website, Store and Store View");
		$I->comment("Entering Action Group [AdminCreateWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageAdminCreateWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadAdminCreateWebsite
		$I->comment("Create Website");
		$I->fillField("#website_name", "Second Website" . msq("customWebsite")); // stepKey: enterWebsiteNameAdminCreateWebsite
		$I->fillField("#website_code", "second_website" . msq("customWebsite")); // stepKey: enterWebsiteCodeAdminCreateWebsite
		$I->click("#save"); // stepKey: clickSaveWebsiteAdminCreateWebsite
		$I->waitForPageLoad(60); // stepKey: clickSaveWebsiteAdminCreateWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadAdminCreateWebsite
		$I->see("You saved the website."); // stepKey: seeSavedMessageAdminCreateWebsite
		$I->comment("Exiting Action Group [AdminCreateWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Entering Action Group [AdminCreateStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewAdminCreateStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AdminCreateStore
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Second Website" . msq("customWebsite")); // stepKey: selectWebsiteAdminCreateStore
		$I->fillField("#group_name", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupNameAdminCreateStore
		$I->fillField("#group_code", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupCodeAdminCreateStore
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryAdminCreateStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupAdminCreateStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupAdminCreateStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadAdminCreateStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageAdminCreateStore
		$I->comment("Exiting Action Group [AdminCreateStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Entering Action Group [AdminCreateStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewAdminCreateStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AdminCreateStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStoreGroup")); // stepKey: selectStoreAdminCreateStoreView
		$I->fillField("#store_name", "store" . msq("customStore")); // stepKey: enterStoreViewNameAdminCreateStoreView
		$I->fillField("#store_code", "store" . msq("customStore")); // stepKey: enterStoreViewCodeAdminCreateStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusAdminCreateStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewAdminCreateStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewAdminCreateStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalAdminCreateStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalAdminCreateStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteAdminCreateStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalAdminCreateStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalAdminCreateStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageAdminCreateStoreView
		$I->comment("Exiting Action Group [AdminCreateStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Set Configuration");
		$I->createEntity("paymentMethodsSettingConfig", "test", "CatalogPriceScopeWebsite", [], []); // stepKey: paymentMethodsSettingConfig
		$I->comment("Set advanced pricing for all 4 products");
		$I->comment("Entering Action Group [searchForSimpleProduct1] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForSimpleProduct1
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForSimpleProduct1
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForSimpleProduct1
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForSimpleProduct1
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForSimpleProduct1WaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('product1', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchForSimpleProduct1
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForSimpleProduct1
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForSimpleProduct1WaitForPageLoad
		$I->comment("Exiting Action Group [searchForSimpleProduct1] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [openEditProduct1] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('product1', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProduct1
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct1
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('product1', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct1
		$I->comment("Exiting Action Group [openEditProduct1] OpenEditProductOnBackendActionGroup");
		$I->comment("Entering Action Group [ProductSetWebsite] ProductSetWebsiteActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToWebsitesProductSetWebsite
		$I->waitForPageLoad(30); // stepKey: scrollToWebsitesProductSetWebsiteWaitForPageLoad
		$I->conditionalClick("div[data-index='websites']", "//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']", false); // stepKey: clickToOpenProductInWebsiteProductSetWebsite
		$I->waitForPageLoad(30); // stepKey: waitForPageOpenedProductSetWebsite
		$I->click("//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectWebsiteProductSetWebsite
		$I->click("#save-button"); // stepKey: clickSaveProductProductSetWebsite
		$I->waitForPageLoad(30); // stepKey: clickSaveProductProductSetWebsiteWaitForPageLoad
		$I->waitForPageLoad(60); // stepKey: waitForProducrSavedProductSetWebsite
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSaveSuccessMessageProductSetWebsite
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveSuccessMessageProductSetWebsite
		$I->comment("Exiting Action Group [ProductSetWebsite] ProductSetWebsiteActionGroup");
		$I->comment("Entering Action Group [ProductSetAdvancedPricing1] ProductSetAdvancedPricingActionGroup");
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButtonProductSetAdvancedPricing1
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButtonProductSetAdvancedPricing1WaitForPageLoad
		$I->waitForElementVisible("[data-action='add_new_row']", 30); // stepKey: waitForCustomerGroupPriceAddButtonProductSetAdvancedPricing1
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupPriceAddButtonProductSetAdvancedPricing1WaitForPageLoad
		$I->click("[data-action='add_new_row']"); // stepKey: addCustomerGroupAllGroupsQty1PriceDiscountAnd10percentProductSetAdvancedPricing1
		$I->waitForPageLoad(30); // stepKey: addCustomerGroupAllGroupsQty1PriceDiscountAnd10percentProductSetAdvancedPricing1WaitForPageLoad
		$I->waitForElement("[name='product[tier_price][0][cust_group]']", 30); // stepKey: waitForSelectCustomerGroupNameAttribute2ProductSetAdvancedPricing1
		$I->selectOption("[name='product[tier_price][0][website_id]']", "Second Website" . msq("customWebsite")); // stepKey: selectProductWebsiteValueProductSetAdvancedPricing1
		$I->selectOption("[name='product[tier_price][0][cust_group]']", "Retailer"); // stepKey: selectProductCustomGroupValueProductSetAdvancedPricing1
		$I->fillField("[name='product[tier_price][0][price_qty]']", "1"); // stepKey: fillProductTierPriceQtyInputProductSetAdvancedPricing1
		$I->selectOption("[name='product[tier_price][0][value_type]']", "Discount"); // stepKey: selectProductTierPriceValueTypeProductSetAdvancedPricing1
		$I->fillField("[name='product[tier_price][0][percentage_value]']", "45"); // stepKey: selectProductTierPricePriceInputProductSetAdvancedPricing1
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButtonProductSetAdvancedPricing1
		$I->waitForPageLoad(30); // stepKey: clickDoneButtonProductSetAdvancedPricing1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: WaitForProductSaveProductSetAdvancedPricing1
		$I->click("#save-button"); // stepKey: clickSaveProduct1ProductSetAdvancedPricing1
		$I->waitForPageLoad(30); // stepKey: clickSaveProduct1ProductSetAdvancedPricing1WaitForPageLoad
		$I->waitForPageLoad(60); // stepKey: WaitForProductSave1ProductSetAdvancedPricing1
		$I->see("You saved the product."); // stepKey: seeSaveConfirmationProductSetAdvancedPricing1
		$I->comment("Exiting Action Group [ProductSetAdvancedPricing1] ProductSetAdvancedPricingActionGroup");
		$I->comment("Entering Action Group [searchForSimpleProduct2] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForSimpleProduct2
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForSimpleProduct2
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForSimpleProduct2
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForSimpleProduct2
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForSimpleProduct2WaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('product2', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchForSimpleProduct2
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForSimpleProduct2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForSimpleProduct2WaitForPageLoad
		$I->comment("Exiting Action Group [searchForSimpleProduct2] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [openEditProduct2] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('product2', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProduct2
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct2
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('product2', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct2
		$I->comment("Exiting Action Group [openEditProduct2] OpenEditProductOnBackendActionGroup");
		$I->comment("Entering Action Group [ProductSetWebsite2] ProductSetWebsiteActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToWebsitesProductSetWebsite2
		$I->waitForPageLoad(30); // stepKey: scrollToWebsitesProductSetWebsite2WaitForPageLoad
		$I->conditionalClick("div[data-index='websites']", "//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']", false); // stepKey: clickToOpenProductInWebsiteProductSetWebsite2
		$I->waitForPageLoad(30); // stepKey: waitForPageOpenedProductSetWebsite2
		$I->click("//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectWebsiteProductSetWebsite2
		$I->click("#save-button"); // stepKey: clickSaveProductProductSetWebsite2
		$I->waitForPageLoad(30); // stepKey: clickSaveProductProductSetWebsite2WaitForPageLoad
		$I->waitForPageLoad(60); // stepKey: waitForProducrSavedProductSetWebsite2
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSaveSuccessMessageProductSetWebsite2
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveSuccessMessageProductSetWebsite2
		$I->comment("Exiting Action Group [ProductSetWebsite2] ProductSetWebsiteActionGroup");
		$I->comment("Entering Action Group [ProductSetAdvancedPricing2] ProductSetAdvancedPricingActionGroup");
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButtonProductSetAdvancedPricing2
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButtonProductSetAdvancedPricing2WaitForPageLoad
		$I->waitForElementVisible("[data-action='add_new_row']", 30); // stepKey: waitForCustomerGroupPriceAddButtonProductSetAdvancedPricing2
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupPriceAddButtonProductSetAdvancedPricing2WaitForPageLoad
		$I->click("[data-action='add_new_row']"); // stepKey: addCustomerGroupAllGroupsQty1PriceDiscountAnd10percentProductSetAdvancedPricing2
		$I->waitForPageLoad(30); // stepKey: addCustomerGroupAllGroupsQty1PriceDiscountAnd10percentProductSetAdvancedPricing2WaitForPageLoad
		$I->waitForElement("[name='product[tier_price][0][cust_group]']", 30); // stepKey: waitForSelectCustomerGroupNameAttribute2ProductSetAdvancedPricing2
		$I->selectOption("[name='product[tier_price][0][website_id]']", "Second Website" . msq("customWebsite")); // stepKey: selectProductWebsiteValueProductSetAdvancedPricing2
		$I->selectOption("[name='product[tier_price][0][cust_group]']", "Retailer"); // stepKey: selectProductCustomGroupValueProductSetAdvancedPricing2
		$I->fillField("[name='product[tier_price][0][price_qty]']", "1"); // stepKey: fillProductTierPriceQtyInputProductSetAdvancedPricing2
		$I->selectOption("[name='product[tier_price][0][value_type]']", "Discount"); // stepKey: selectProductTierPriceValueTypeProductSetAdvancedPricing2
		$I->fillField("[name='product[tier_price][0][percentage_value]']", "45"); // stepKey: selectProductTierPricePriceInputProductSetAdvancedPricing2
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButtonProductSetAdvancedPricing2
		$I->waitForPageLoad(30); // stepKey: clickDoneButtonProductSetAdvancedPricing2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: WaitForProductSaveProductSetAdvancedPricing2
		$I->click("#save-button"); // stepKey: clickSaveProduct1ProductSetAdvancedPricing2
		$I->waitForPageLoad(30); // stepKey: clickSaveProduct1ProductSetAdvancedPricing2WaitForPageLoad
		$I->waitForPageLoad(60); // stepKey: WaitForProductSave1ProductSetAdvancedPricing2
		$I->see("You saved the product."); // stepKey: seeSaveConfirmationProductSetAdvancedPricing2
		$I->comment("Exiting Action Group [ProductSetAdvancedPricing2] ProductSetAdvancedPricingActionGroup");
		$I->comment("Entering Action Group [searchForSimpleProduct3] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForSimpleProduct3
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForSimpleProduct3
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForSimpleProduct3
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForSimpleProduct3
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForSimpleProduct3WaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('product3', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchForSimpleProduct3
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForSimpleProduct3
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForSimpleProduct3WaitForPageLoad
		$I->comment("Exiting Action Group [searchForSimpleProduct3] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [openEditProduct3] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('product3', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProduct3
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct3
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('product3', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct3
		$I->comment("Exiting Action Group [openEditProduct3] OpenEditProductOnBackendActionGroup");
		$I->comment("Entering Action Group [ProductSetWebsite3] ProductSetWebsiteActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToWebsitesProductSetWebsite3
		$I->waitForPageLoad(30); // stepKey: scrollToWebsitesProductSetWebsite3WaitForPageLoad
		$I->conditionalClick("div[data-index='websites']", "//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']", false); // stepKey: clickToOpenProductInWebsiteProductSetWebsite3
		$I->waitForPageLoad(30); // stepKey: waitForPageOpenedProductSetWebsite3
		$I->click("//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectWebsiteProductSetWebsite3
		$I->click("#save-button"); // stepKey: clickSaveProductProductSetWebsite3
		$I->waitForPageLoad(30); // stepKey: clickSaveProductProductSetWebsite3WaitForPageLoad
		$I->waitForPageLoad(60); // stepKey: waitForProducrSavedProductSetWebsite3
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSaveSuccessMessageProductSetWebsite3
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveSuccessMessageProductSetWebsite3
		$I->comment("Exiting Action Group [ProductSetWebsite3] ProductSetWebsiteActionGroup");
		$I->comment("Entering Action Group [ProductSetAdvancedPricing3] ProductSetAdvancedPricingActionGroup");
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButtonProductSetAdvancedPricing3
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButtonProductSetAdvancedPricing3WaitForPageLoad
		$I->waitForElementVisible("[data-action='add_new_row']", 30); // stepKey: waitForCustomerGroupPriceAddButtonProductSetAdvancedPricing3
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupPriceAddButtonProductSetAdvancedPricing3WaitForPageLoad
		$I->click("[data-action='add_new_row']"); // stepKey: addCustomerGroupAllGroupsQty1PriceDiscountAnd10percentProductSetAdvancedPricing3
		$I->waitForPageLoad(30); // stepKey: addCustomerGroupAllGroupsQty1PriceDiscountAnd10percentProductSetAdvancedPricing3WaitForPageLoad
		$I->waitForElement("[name='product[tier_price][0][cust_group]']", 30); // stepKey: waitForSelectCustomerGroupNameAttribute2ProductSetAdvancedPricing3
		$I->selectOption("[name='product[tier_price][0][website_id]']", "Second Website" . msq("customWebsite")); // stepKey: selectProductWebsiteValueProductSetAdvancedPricing3
		$I->selectOption("[name='product[tier_price][0][cust_group]']", "Retailer"); // stepKey: selectProductCustomGroupValueProductSetAdvancedPricing3
		$I->fillField("[name='product[tier_price][0][price_qty]']", "1"); // stepKey: fillProductTierPriceQtyInputProductSetAdvancedPricing3
		$I->selectOption("[name='product[tier_price][0][value_type]']", "Discount"); // stepKey: selectProductTierPriceValueTypeProductSetAdvancedPricing3
		$I->fillField("[name='product[tier_price][0][percentage_value]']", "45"); // stepKey: selectProductTierPricePriceInputProductSetAdvancedPricing3
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButtonProductSetAdvancedPricing3
		$I->waitForPageLoad(30); // stepKey: clickDoneButtonProductSetAdvancedPricing3WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: WaitForProductSaveProductSetAdvancedPricing3
		$I->click("#save-button"); // stepKey: clickSaveProduct1ProductSetAdvancedPricing3
		$I->waitForPageLoad(30); // stepKey: clickSaveProduct1ProductSetAdvancedPricing3WaitForPageLoad
		$I->waitForPageLoad(60); // stepKey: WaitForProductSave1ProductSetAdvancedPricing3
		$I->see("You saved the product."); // stepKey: seeSaveConfirmationProductSetAdvancedPricing3
		$I->comment("Exiting Action Group [ProductSetAdvancedPricing3] ProductSetAdvancedPricingActionGroup");
		$I->comment("Entering Action Group [searchForSimpleProduct4] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForSimpleProduct4
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForSimpleProduct4
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForSimpleProduct4
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForSimpleProduct4
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForSimpleProduct4WaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('product4', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchForSimpleProduct4
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForSimpleProduct4
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForSimpleProduct4WaitForPageLoad
		$I->comment("Exiting Action Group [searchForSimpleProduct4] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [openEditProduct4] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('product4', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProduct4
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct4
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('product4', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct4
		$I->comment("Exiting Action Group [openEditProduct4] OpenEditProductOnBackendActionGroup");
		$I->comment("Entering Action Group [ProductSetWebsite4] ProductSetWebsiteActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToWebsitesProductSetWebsite4
		$I->waitForPageLoad(30); // stepKey: scrollToWebsitesProductSetWebsite4WaitForPageLoad
		$I->conditionalClick("div[data-index='websites']", "//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']", false); // stepKey: clickToOpenProductInWebsiteProductSetWebsite4
		$I->waitForPageLoad(30); // stepKey: waitForPageOpenedProductSetWebsite4
		$I->click("//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectWebsiteProductSetWebsite4
		$I->click("#save-button"); // stepKey: clickSaveProductProductSetWebsite4
		$I->waitForPageLoad(30); // stepKey: clickSaveProductProductSetWebsite4WaitForPageLoad
		$I->waitForPageLoad(60); // stepKey: waitForProducrSavedProductSetWebsite4
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSaveSuccessMessageProductSetWebsite4
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveSuccessMessageProductSetWebsite4
		$I->comment("Exiting Action Group [ProductSetWebsite4] ProductSetWebsiteActionGroup");
		$I->comment("Entering Action Group [ProductSetAdvancedPricing4] ProductSetAdvancedPricingActionGroup");
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButtonProductSetAdvancedPricing4
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButtonProductSetAdvancedPricing4WaitForPageLoad
		$I->waitForElementVisible("[data-action='add_new_row']", 30); // stepKey: waitForCustomerGroupPriceAddButtonProductSetAdvancedPricing4
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupPriceAddButtonProductSetAdvancedPricing4WaitForPageLoad
		$I->click("[data-action='add_new_row']"); // stepKey: addCustomerGroupAllGroupsQty1PriceDiscountAnd10percentProductSetAdvancedPricing4
		$I->waitForPageLoad(30); // stepKey: addCustomerGroupAllGroupsQty1PriceDiscountAnd10percentProductSetAdvancedPricing4WaitForPageLoad
		$I->waitForElement("[name='product[tier_price][0][cust_group]']", 30); // stepKey: waitForSelectCustomerGroupNameAttribute2ProductSetAdvancedPricing4
		$I->selectOption("[name='product[tier_price][0][website_id]']", "Second Website" . msq("customWebsite")); // stepKey: selectProductWebsiteValueProductSetAdvancedPricing4
		$I->selectOption("[name='product[tier_price][0][cust_group]']", "Retailer"); // stepKey: selectProductCustomGroupValueProductSetAdvancedPricing4
		$I->fillField("[name='product[tier_price][0][price_qty]']", "1"); // stepKey: fillProductTierPriceQtyInputProductSetAdvancedPricing4
		$I->selectOption("[name='product[tier_price][0][value_type]']", "Discount"); // stepKey: selectProductTierPriceValueTypeProductSetAdvancedPricing4
		$I->fillField("[name='product[tier_price][0][percentage_value]']", "45"); // stepKey: selectProductTierPricePriceInputProductSetAdvancedPricing4
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButtonProductSetAdvancedPricing4
		$I->waitForPageLoad(30); // stepKey: clickDoneButtonProductSetAdvancedPricing4WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: WaitForProductSaveProductSetAdvancedPricing4
		$I->click("#save-button"); // stepKey: clickSaveProduct1ProductSetAdvancedPricing4
		$I->waitForPageLoad(30); // stepKey: clickSaveProduct1ProductSetAdvancedPricing4WaitForPageLoad
		$I->waitForPageLoad(60); // stepKey: WaitForProductSave1ProductSetAdvancedPricing4
		$I->see("You saved the product."); // stepKey: seeSaveConfirmationProductSetAdvancedPricing4
		$I->comment("Exiting Action Group [ProductSetAdvancedPricing4] ProductSetAdvancedPricingActionGroup");
		$I->comment("Entering Action Group [ClearProductsFilterActionGroup] ClearProductsFilterActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexClearProductsFilterActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForProductsPageToLoadClearProductsFilterActionGroup
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetClearProductsFilterActionGroup
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetClearProductsFilterActionGroupWaitForPageLoad
		$I->comment("Exiting Action Group [ClearProductsFilterActionGroup] ClearProductsFilterActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Edit customer info");
		$I->comment("Entering Action Group [OpenEditCustomerFrom] OpenEditCustomerFromAdminActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersOpenEditCustomerFrom
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1OpenEditCustomerFrom
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersOpenEditCustomerFrom
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersOpenEditCustomerFromWaitForPageLoad
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFilterOpenEditCustomerFrom
		$I->waitForPageLoad(30); // stepKey: openFilterOpenEditCustomerFromWaitForPageLoad
		$I->fillField("input[name=email]", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: filterEmailOpenEditCustomerFrom
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterOpenEditCustomerFrom
		$I->waitForPageLoad(30); // stepKey: applyFilterOpenEditCustomerFromWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenEditCustomerFrom
		$I->click("tr[data-repeat-index='0'] .action-menu-item"); // stepKey: clickEditOpenEditCustomerFrom
		$I->waitForPageLoad(30); // stepKey: clickEditOpenEditCustomerFromWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3OpenEditCustomerFrom
		$I->comment("Exiting Action Group [OpenEditCustomerFrom] OpenEditCustomerFromAdminActionGroup");
		$I->click("//a/span[text()='Account Information']"); // stepKey: ClickOnAccountInformationSection
		$I->waitForPageLoad(30); // stepKey: waitForPageOpened1
		$I->selectOption("[name='customer[group_id]']", "Retailer"); // stepKey: Group
		$I->selectOption("//select[@name='customer[sendemail_store_id]']", "store" . msq("customStore")); // stepKey: clickToSelectStore
		$I->click("//button[@title='Save Customer']"); // stepKey: save
		$I->waitForPageLoad(30); // stepKey: waitForCustomersPage
		$I->see("You saved the customer."); // stepKey: CustomerIsSaved
		$I->comment("Entering Action Group [navigateToCustomers] AdminOpenCustomersGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomersGridPageNavigateToCustomers
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToCustomers
		$I->comment("Exiting Action Group [navigateToCustomers] AdminOpenCustomersGridActionGroup");
		$I->click(".admin__data-grid-header .action-tertiary.action-clear"); // stepKey: ClearFilters
		$I->waitForPageLoad(30); // stepKey: ClearFiltersWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFiltersClear
		$I->comment("Create Cart Price Rule");
		$I->comment("Entering Action Group [amOnCartPriceList] AdminOpenCartPriceRulesPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: openCartPriceRulesPageAmOnCartPriceList
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAmOnCartPriceList
		$I->comment("Exiting Action Group [amOnCartPriceList] AdminOpenCartPriceRulesPageActionGroup");
		$I->click("#add"); // stepKey: clickAddNewRule
		$I->waitForPageLoad(30); // stepKey: clickAddNewRuleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageDiscountPageIsLoaded
		$I->fillField("input[name='name']", "ship"); // stepKey: fillRuleName
		$I->selectOption("select[name='website_ids']", "Second Website" . msq("customWebsite")); // stepKey: selectWebsites
		$I->selectOption("select[name='customer_group_ids']", "Retailer"); // stepKey: selectCustomerGroup
		$I->selectOption("select[name='coupon_type']", "Specific Coupon"); // stepKey: selectCouponType
		$I->fillField("input[name='coupon_code']", "ship"); // stepKey: setCode
		$I->fillField("//input[@name='uses_per_customer']", "0"); // stepKey: setUserPerCustomer
		$I->fillField("//input[@name='uses_per_coupon']", "0"); // stepKey: setUserPerCoupon
		$I->fillField("//*[@name='sort_order']", "0"); // stepKey: setPriority
		$I->click("div[data-index='actions']"); // stepKey: clickToExpandActions
		$I->waitForPageLoad(30); // stepKey: clickToExpandActionsWaitForPageLoad
		$I->selectOption("//select[@name='simple_free_shipping']", "For shipment with matching items"); // stepKey: selectFreeShippingType
		$I->click("#save_and_continue"); // stepKey: clickSaveAndContinueButton
		$I->waitForPageLoad(30); // stepKey: clickSaveAndContinueButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCartPriceRuleSaved
		$I->see("You saved the rule."); // stepKey: RuleSaved
		$I->comment("Create new order");
		$I->comment("Entering Action Group [CreateNewOrder] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadCreateNewOrder
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleCreateNewOrder
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderCreateNewOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGridLoadCreateNewOrder
		$I->comment("Clear grid filters");
		$I->conditionalClick("#sales_order_create_customer_grid [data-action='grid-filter-reset']", "#sales_order_create_customer_grid [data-action='grid-filter-reset']", true); // stepKey: clearExistingCustomerFiltersCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: clearExistingCustomerFiltersCreateNewOrderWaitForPageLoad
		$I->fillField("#sales_order_create_customer_grid_filter_email", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: filterEmailCreateNewOrder
		$I->click(".action-secondary[title='Search']"); // stepKey: applyFilterCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: waitForFilteredCustomerGridLoadCreateNewOrder
		$I->click("tr:nth-of-type(1)[data-role='row']"); // stepKey: clickOnCustomerCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadCreateNewOrder
		$I->comment("Select store view if appears");
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'store" . msq("customStore") . "')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'store" . msq("customStore") . "')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsCreateNewOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadAfterStoreSelectCreateNewOrder
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleCreateNewOrder
		$I->comment("Exiting Action Group [CreateNewOrder] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->click("#add_products"); // stepKey: clickToAddProduct
		$I->waitForPageLoad(60); // stepKey: clickToAddProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductsOpened
		$I->comment("TEST CASE #1");
		$I->comment("Add 3 products to order with specified quantity");
		$I->click("//td[contains(., '" . $I->retrieveEntityField('product1', 'sku', 'test') . "')]/following-sibling::td[contains(@class, 'col-select col-in_products')]/label/input"); // stepKey: selectProduct1
		$I->fillField("//td[contains(., '" . $I->retrieveEntityField('product1', 'sku', 'test') . "')]/following-sibling::td[contains(@class, 'col-qty')]/input", "10"); // stepKey: AddProductQuantity1
		$I->click("//td[contains(., '" . $I->retrieveEntityField('product2', 'sku', 'test') . "')]/following-sibling::td[contains(@class, 'col-select col-in_products')]/label/input"); // stepKey: selectProduct2
		$I->fillField("//td[contains(., '" . $I->retrieveEntityField('product2', 'sku', 'test') . "')]/following-sibling::td[contains(@class, 'col-qty')]/input", "10"); // stepKey: AddProductQuantity2
		$I->click("//td[contains(., '" . $I->retrieveEntityField('product3', 'sku', 'test') . "')]/following-sibling::td[contains(@class, 'col-select col-in_products')]/label/input"); // stepKey: selectProduct3
		$I->fillField("//td[contains(., '" . $I->retrieveEntityField('product3', 'sku', 'test') . "')]/following-sibling::td[contains(@class, 'col-qty')]/input", "10"); // stepKey: AddProductQuantity3
		$I->click("//span[text()='Add Selected Product(s) to Order']"); // stepKey: addProductsToOrder
		$I->waitForLoadingMaskToDisappear(); // stepKey: wait6
		$I->comment("Verify tier price values");
		$checkProductPrice1 = $I->grabTextFrom("//span[.='" . $I->retrieveEntityField('product1', 'name', 'test') . "']/parent::td/following-sibling::td[@class='col-price col-row-subtotal']/span"); // stepKey: checkProductPrice1
		$I->assertEquals("$676.50", $checkProductPrice1); // stepKey: verifyPrice1
		$checkProductPrice2 = $I->grabTextFrom("//span[.='" . $I->retrieveEntityField('product2', 'name', 'test') . "']/parent::td/following-sibling::td[@class='col-price col-row-subtotal']/span"); // stepKey: checkProductPrice2
		$I->assertEquals("$676.50", $checkProductPrice2); // stepKey: verifyPrice2
		$checkProductPrice3 = $I->grabTextFrom("//span[.='" . $I->retrieveEntityField('product3', 'name', 'test') . "']/parent::td/following-sibling::td[@class='col-price col-row-subtotal']/span"); // stepKey: checkProductPrice3
		$I->assertEquals("$676.50", $checkProductPrice3); // stepKey: verifyPrice3
		$I->comment("Edit order and verify values");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoaded2
		$I->click("//span[.='" . $I->retrieveEntityField('product1', 'name', 'test') . "']/parent::td/following-sibling::td/div//span[contains(text(),'Custom Price')]"); // stepKey: ClickOnCustomPrice
		$I->fillField("//span[.='" . $I->retrieveEntityField('product1', 'name', 'test') . "']/parent::td/following-sibling::td[@class='col-qty']/input", "5"); // stepKey: ClickOnQuantity
		$I->waitForLoadingMaskToDisappear(); // stepKey: wait1
		$I->click("//span[text()='Update Items and Quantities']"); // stepKey: ClickToUpdate
		$I->waitForLoadingMaskToDisappear(); // stepKey: wait2
		$checkProductPrice4 = $I->grabTextFrom("//span[.='" . $I->retrieveEntityField('product1', 'name', 'test') . "']/parent::td/following-sibling::td[@class='col-price col-row-subtotal']/span"); // stepKey: checkProductPrice4
		$I->assertEquals("$615.00", $checkProductPrice4); // stepKey: verifyPrice4
		$checkProductPrice5 = $I->grabTextFrom("//span[.='" . $I->retrieveEntityField('product2', 'name', 'test') . "']/parent::td/following-sibling::td[@class='col-price col-row-subtotal']/span"); // stepKey: checkProductPrice5
		$I->assertEquals("$676.50", $checkProductPrice5); // stepKey: verifyPrice5
		$checkProductPrice6 = $I->grabTextFrom("//span[.='" . $I->retrieveEntityField('product3', 'name', 'test') . "']/parent::td/following-sibling::td[@class='col-price col-row-subtotal']/span"); // stepKey: checkProductPrice6
		$I->assertEquals("$676.50", $checkProductPrice3); // stepKey: verifyPrice6
		$I->comment("Remove products from order");
		$I->selectOption("//span[.='" . $I->retrieveEntityField('product1', 'name', 'test') . "']/parent::td/following-sibling::td/select[@class='admin__control-select']", "Remove"); // stepKey: clickToRemove1
		$I->selectOption("//span[.='" . $I->retrieveEntityField('product2', 'name', 'test') . "']/parent::td/following-sibling::td/select[@class='admin__control-select']", "Remove"); // stepKey: clickToRemove2
		$I->selectOption("//span[.='" . $I->retrieveEntityField('product3', 'name', 'test') . "']/parent::td/following-sibling::td/select[@class='admin__control-select']", "Remove"); // stepKey: clickToRemove3
		$I->waitForLoadingMaskToDisappear(); // stepKey: wait3
		$I->click("//span[text()='Update Items and Quantities']"); // stepKey: ClickToUpdate1
		$I->waitForPageLoad(30); // stepKey: WaitProductsDeleted
		$I->comment("TEST CASE #2");
		$I->comment("Add 3 products to order with specified quantity");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPage
		$I->click("#add_products"); // stepKey: clickToAddProduct1
		$I->waitForPageLoad(60); // stepKey: clickToAddProduct1WaitForPageLoad
		$I->click("//td[contains(., '" . $I->retrieveEntityField('product1', 'sku', 'test') . "')]/following-sibling::td[contains(@class, 'col-select col-in_products')]/label/input"); // stepKey: selectProduct5
		$I->fillField("//td[contains(., '" . $I->retrieveEntityField('product1', 'sku', 'test') . "')]/following-sibling::td[contains(@class, 'col-qty')]/input", "10"); // stepKey: AddProductQuantity5
		$I->click("//td[contains(., '" . $I->retrieveEntityField('product2', 'sku', 'test') . "')]/following-sibling::td[contains(@class, 'col-select col-in_products')]/label/input"); // stepKey: selectProduct6
		$I->fillField("//td[contains(., '" . $I->retrieveEntityField('product2', 'sku', 'test') . "')]/following-sibling::td[contains(@class, 'col-qty')]/input", "10"); // stepKey: AddProductQuantity6
		$I->click("//td[contains(., '" . $I->retrieveEntityField('product3', 'sku', 'test') . "')]/following-sibling::td[contains(@class, 'col-select col-in_products')]/label/input"); // stepKey: selectProduct7
		$I->fillField("//td[contains(., '" . $I->retrieveEntityField('product3', 'sku', 'test') . "')]/following-sibling::td[contains(@class, 'col-qty')]/input", "10"); // stepKey: AddProductQuantity7
		$I->click("//span[text()='Add Selected Product(s) to Order']"); // stepKey: addProductsToOrder1
		$I->waitForLoadingMaskToDisappear(); // stepKey: wait7
		$I->comment("Verify tier price values");
		$checkProductPrice7 = $I->grabTextFrom("//span[.='" . $I->retrieveEntityField('product1', 'name', 'test') . "']/parent::td/following-sibling::td[@class='col-price col-row-subtotal']/span"); // stepKey: checkProductPrice7
		$I->assertEquals("$676.50", $checkProductPrice7); // stepKey: verifyPrice7
		$checkProductPrice8 = $I->grabTextFrom("//span[.='" . $I->retrieveEntityField('product2', 'name', 'test') . "']/parent::td/following-sibling::td[@class='col-price col-row-subtotal']/span"); // stepKey: checkProductPrice8
		$I->assertEquals("$676.50", $checkProductPrice8); // stepKey: verifyPrice8
		$checkProductPrice9 = $I->grabTextFrom("//span[.='" . $I->retrieveEntityField('product3', 'name', 'test') . "']/parent::td/following-sibling::td[@class='col-price col-row-subtotal']/span"); // stepKey: checkProductPrice9
		$I->assertEquals("$676.50", $checkProductPrice9); // stepKey: verifyPrice9
		$I->comment("Add one more product and verify values");
		$I->waitForPageLoad(30); // stepKey: waitForPgeLoaded3
		$I->click("#add_products"); // stepKey: clickToAddProduct2
		$I->waitForPageLoad(60); // stepKey: clickToAddProduct2WaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: wait8
		$I->click("//td[contains(., '" . $I->retrieveEntityField('product4', 'sku', 'test') . "')]/following-sibling::td[contains(@class, 'col-select col-in_products')]/label/input"); // stepKey: selectProduct8
		$I->fillField("//td[contains(., '" . $I->retrieveEntityField('product4', 'sku', 'test') . "')]/following-sibling::td[contains(@class, 'col-qty')]/input", "10"); // stepKey: AddProductQuantity9
		$I->click("//span[text()='Add Selected Product(s) to Order']"); // stepKey: addProductsToOrder2
		$I->waitForLoadingMaskToDisappear(); // stepKey: wait9
		$checkProductPrice10 = $I->grabTextFrom("//span[.='" . $I->retrieveEntityField('product4', 'name', 'test') . "']/parent::td/following-sibling::td[@class='col-price col-row-subtotal']/span"); // stepKey: checkProductPrice10
		$I->assertEquals("$676.50", $checkProductPrice10); // stepKey: verifyPrice10
		$checkProductPrice11 = $I->grabTextFrom("//span[.='" . $I->retrieveEntityField('product1', 'name', 'test') . "']/parent::td/following-sibling::td[@class='col-price col-row-subtotal']/span"); // stepKey: checkProductPrice11
		$I->assertEquals("$676.50", $checkProductPrice11); // stepKey: verifyPrice11
		$checkProductPrice12 = $I->grabTextFrom("//span[.='" . $I->retrieveEntityField('product2', 'name', 'test') . "']/parent::td/following-sibling::td[@class='col-price col-row-subtotal']/span"); // stepKey: checkProductPrice12
		$I->assertEquals("$676.50", $checkProductPrice12); // stepKey: verifyPrice12
		$checkProductPrice13 = $I->grabTextFrom("//span[.='" . $I->retrieveEntityField('product3', 'name', 'test') . "']/parent::td/following-sibling::td[@class='col-price col-row-subtotal']/span"); // stepKey: checkProductPrice13
		$I->assertEquals("$676.50", $checkProductPrice13); // stepKey: verifyPrice13
		$I->selectOption("//span[.='" . $I->retrieveEntityField('product1', 'name', 'test') . "']/parent::td/following-sibling::td/select[@class='admin__control-select']", "Remove"); // stepKey: clickToRemove4
		$I->selectOption("//span[.='" . $I->retrieveEntityField('product2', 'name', 'test') . "']/parent::td/following-sibling::td/select[@class='admin__control-select']", "Remove"); // stepKey: clickToRemove5
		$I->selectOption("//span[.='" . $I->retrieveEntityField('product3', 'name', 'test') . "']/parent::td/following-sibling::td/select[@class='admin__control-select']", "Remove"); // stepKey: clickToRemove6
		$I->waitForLoadingMaskToDisappear(); // stepKey: wait4
		$I->click("//span[text()='Update Items and Quantities']"); // stepKey: ClickToUpdate2
		$I->waitForLoadingMaskToDisappear(); // stepKey: wait10
		$I->comment("TEST CASE #3");
		$I->waitForPageLoad(30); // stepKey: WaitProductsDeleted1
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPage1
		$I->click("#add_products"); // stepKey: clickToAddProduct4
		$I->waitForPageLoad(60); // stepKey: clickToAddProduct4WaitForPageLoad
		$I->click("//td[contains(., '" . $I->retrieveEntityField('product1', 'sku', 'test') . "')]/following-sibling::td[contains(@class, 'col-select col-in_products')]/label/input"); // stepKey: selectProduct9
		$I->fillField("//td[contains(., '" . $I->retrieveEntityField('product1', 'sku', 'test') . "')]/following-sibling::td[contains(@class, 'col-qty')]/input", "10"); // stepKey: AddProductQuantity10
		$I->click("//span[text()='Add Selected Product(s) to Order']"); // stepKey: addProductsToOrder3
		$I->waitForLoadingMaskToDisappear(); // stepKey: wait11
		$I->fillField("#coupons:code", "ship"); // stepKey: AddCouponCode
		$I->waitForLoadingMaskToDisappear(); // stepKey: wait5
		$I->click("//span[text()='Update Items and Quantities']"); // stepKey: ClickToUpdate3
		$I->waitForLoadingMaskToDisappear(); // stepKey: wait12
		$checkProductPrice14 = $I->grabTextFrom("//span[.='" . $I->retrieveEntityField('product1', 'name', 'test') . "']/parent::td/following-sibling::td[@class='col-price col-row-subtotal']/span"); // stepKey: checkProductPrice14
		$checkProductPrice15 = $I->grabTextFrom("//span[.='" . $I->retrieveEntityField('product4', 'name', 'test') . "']/parent::td/following-sibling::td[@class='col-price col-row-subtotal']/span"); // stepKey: checkProductPrice15
		$I->assertEquals("$676.50", $checkProductPrice14); // stepKey: verifyPrice14
		$I->assertEquals("$676.50", $checkProductPrice15); // stepKey: verifyPrice15
	}
}
