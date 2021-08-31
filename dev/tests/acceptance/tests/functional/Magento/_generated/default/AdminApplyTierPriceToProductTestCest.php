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
 * @Title("MAGETWO-68921: You should be able to apply tier price to a product.")
 * @Description("You should be able to apply tier price to a product.<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminApplyTierPriceToProductTest/AdminApplyTierPriceToProductTest.xml<br>")
 * @TestCaseId("MAGETWO-68921")
 * @group product
 */
class AdminApplyTierPriceToProductTestCest
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
		$createSimpleUSCustomerFields['group_id'] = "1";
		$I->createEntity("createSimpleUSCustomer", "hook", "Simple_US_Customer", [], $createSimpleUSCustomerFields); // stepKey: createSimpleUSCustomer
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$createSimpleProductFields['price'] = "100";
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct", ["createCategory"], $createSimpleProductFields); // stepKey: createSimpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createSimpleUSCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [navigateToProductIndex1] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex1
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex1
		$I->comment("Exiting Action Group [navigateToProductIndex1] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [resetGridToDefaultKeywordSearch] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetGridToDefaultKeywordSearch
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetGridToDefaultKeywordSearchWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetGridToDefaultKeywordSearch
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetGridToDefaultKeywordSearch
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetGridToDefaultKeywordSearchWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetGridToDefaultKeywordSearch
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetGridToDefaultKeywordSearch
		$I->comment("Exiting Action Group [resetGridToDefaultKeywordSearch] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Stories({"Apply tier price to a product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminApplyTierPriceToProductTest(AcceptanceTester $I)
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
		$I->comment("Case: Group Price");
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
		$I->comment("Entering Action Group [openEditProduct1] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProduct1
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct1
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct1
		$I->comment("Exiting Action Group [openEditProduct1] OpenEditProductOnBackendActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPage1
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButton1
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButton1WaitForPageLoad
		$I->waitForElement("[data-action='add_new_row']", 30); // stepKey: waitForCustomerGroupPriceAddButton1
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupPriceAddButton1WaitForPageLoad
		$I->click("[data-action='add_new_row']"); // stepKey: addCustomerGroupAllGroupsQty1PriceDiscountAnd10percent
		$I->waitForPageLoad(30); // stepKey: addCustomerGroupAllGroupsQty1PriceDiscountAnd10percentWaitForPageLoad
		$I->fillField("[name='product[tier_price][0][price_qty]']", "1"); // stepKey: fillProductTierPriceQtyInput1
		$I->selectOption("[name='product[tier_price][0][value_type]']", "Discount"); // stepKey: selectProductTierPriceValueType1
		$I->fillField("[name='product[tier_price][0][percentage_value]']", "10"); // stepKey: selectProductTierPricePriceInput
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButton1
		$I->waitForPageLoad(30); // stepKey: clickDoneButton1WaitForPageLoad
		$I->comment("Entering Action Group [saveProduct1] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct1
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct1
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct1WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct1
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct1WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct1
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct1
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct1
		$I->comment("Exiting Action Group [saveProduct1] SaveProductFormActionGroup");
		$I->comment("Entering Action Group [customerLogin1] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerLogin1
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerLogin1
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerLogin1
		$I->fillField("#email", $I->retrieveEntityField('createSimpleUSCustomer', 'email', 'test')); // stepKey: fillEmailCustomerLogin1
		$I->fillField("#pass", $I->retrieveEntityField('createSimpleUSCustomer', 'password', 'test')); // stepKey: fillPasswordCustomerLogin1
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerLogin1
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerLogin1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerLogin1
		$I->comment("Exiting Action Group [customerLogin1] LoginToStorefrontActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToCategoryPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1
		$I->seeElement("//span[@data-price-type='finalPrice']//span[@class='price'][contains(.,'90')]"); // stepKey: assertProductFinalPriceIs90_1
		$I->seeElement("//span[@class='price-label'][contains(text(),'Regular Price')]"); // stepKey: assertRegularPriceLabel_1
		$I->seeElement("//span[@data-price-type='oldPrice']//span[@class='price'][contains(., '100')]"); // stepKey: assertRegularPriceAmount_1
		$I->amOnPage("customer/account/logout/"); // stepKey: logoutCustomer1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToCategoryPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3
		$I->seeElement("//span[@data-price-type='finalPrice']//span[@class='price'][contains(.,'90')]"); // stepKey: assertProductFinalPriceIs90_2
		$I->seeElement("//span[@class='price-label'][contains(text(),'Regular Price')]"); // stepKey: assertRegularPriceLabel_2
		$I->seeElement("//span[@data-price-type='oldPrice']//span[@class='price'][contains(., '100')]"); // stepKey: assertRegularPriceAmount_2
		$I->comment("Case: Tier Price for General Customer Group");
		$I->comment("Entering Action Group [navigateToProductIndex2] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex2
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex2
		$I->comment("Exiting Action Group [navigateToProductIndex2] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [openEditProduct2] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProduct2
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct2
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct2
		$I->comment("Exiting Action Group [openEditProduct2] OpenEditProductOnBackendActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPage2
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButton2
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButton2WaitForPageLoad
		$I->waitForElement("[data-action='add_new_row']", 30); // stepKey: waitForcustomerGroupPriceAddButton2
		$I->waitForPageLoad(30); // stepKey: waitForcustomerGroupPriceAddButton2WaitForPageLoad
		$I->waitForElement("[name='product[tier_price][0][cust_group]']", 30); // stepKey: waitForSelectCustomerGroupNameAttribute1
		$I->selectOption("[name='product[tier_price][0][cust_group]']", "General"); // stepKey: selectCustomerGroupGeneral
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButton2
		$I->waitForPageLoad(30); // stepKey: clickDoneButton2WaitForPageLoad
		$I->comment("Entering Action Group [saveProduct2] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct2
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct2
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct2WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct2
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct2WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct2
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct2
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct2
		$I->comment("Exiting Action Group [saveProduct2] SaveProductFormActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToCategoryPage3
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad4
		$I->seeElement("//span[@data-price-type='finalPrice']//span[@class='price'][contains(.,'100')]"); // stepKey: assertProductFinalPriceIs100_1
		$I->dontSeeElement("//span[@class='price-label'][contains(text(),'Regular Price')]"); // stepKey: assertRegularPriceLabel_3
		$I->comment("Entering Action Group [customerLogin2] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerLogin2
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerLogin2
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerLogin2
		$I->fillField("#email", $I->retrieveEntityField('createSimpleUSCustomer', 'email', 'test')); // stepKey: fillEmailCustomerLogin2
		$I->fillField("#pass", $I->retrieveEntityField('createSimpleUSCustomer', 'password', 'test')); // stepKey: fillPasswordCustomerLogin2
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerLogin2
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerLogin2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerLogin2
		$I->comment("Exiting Action Group [customerLogin2] LoginToStorefrontActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToCategoryPage4
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad5
		$I->seeElement("//span[@data-price-type='finalPrice']//span[@class='price'][contains(.,'90')]"); // stepKey: assertProductFinalPriceIs90_3
		$I->seeElement("//span[@class='price-label'][contains(text(),'Regular Price')]"); // stepKey: assertRegularPriceLabel_4
		$I->seeElement("//span[@data-price-type='oldPrice']//span[@class='price'][contains(., '100')]"); // stepKey: assertRegularPriceAmount_3
		$I->comment("Case: Tier Price applied if Product quantity meets Tier Price Condition");
		$I->comment("Entering Action Group [navigateToProductIndex3] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex3
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex3
		$I->comment("Exiting Action Group [navigateToProductIndex3] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [openEditProduct3] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProduct3
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct3
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct3
		$I->comment("Exiting Action Group [openEditProduct3] OpenEditProductOnBackendActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPage3
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButton3
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButton3WaitForPageLoad
		$I->waitForElement("[data-action='add_new_row']", 30); // stepKey: waitForcustomerGroupPriceAddButton3
		$I->waitForPageLoad(30); // stepKey: waitForcustomerGroupPriceAddButton3WaitForPageLoad
		$I->waitForElement("[name='product[tier_price][0][cust_group]']", 30); // stepKey: waitForSelectCustomerGroupNameAttribute2
		$I->selectOption("[name='product[tier_price][0][cust_group]']", "ALL GROUPS"); // stepKey: selectCustomerGroupAllGroups
		$I->fillField("[name='product[tier_price][0][price_qty]']", "15"); // stepKey: fillProductTierPriceQtyInput15
		$I->click("[data-action='add_new_row']"); // stepKey: clickToLoseFocusOnRequiredInputElement
		$I->waitForPageLoad(30); // stepKey: clickToLoseFocusOnRequiredInputElementWaitForPageLoad
		$I->click("[data-action='add_new_row']"); // stepKey: addCustomerGroupAllGroupsQty20PriceDiscountAnd18percent2
		$I->waitForPageLoad(30); // stepKey: addCustomerGroupAllGroupsQty20PriceDiscountAnd18percent2WaitForPageLoad
		$I->fillField("[name='product[tier_price][1][price_qty]']", "20"); // stepKey: fillProductTierPriceQtyInput20
		$I->selectOption("[name='product[tier_price][1][value_type]']", "Discount"); // stepKey: selectProductTierPriceValueType2
		$I->fillField("[name='product[tier_price][1][percentage_value]']", "18"); // stepKey: selectProductTierPricePriceInput18
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButton3
		$I->waitForPageLoad(30); // stepKey: clickDoneButton3WaitForPageLoad
		$I->comment("Entering Action Group [saveProduct3] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct3
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct3
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct3WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct3
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct3WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct3
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct3
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct3
		$I->comment("Exiting Action Group [saveProduct3] SaveProductFormActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToCategoryPage5
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad6
		$I->seeElement("//span[@data-price-type='finalPrice']//span[@class='price'][contains(.,'100')]"); // stepKey: assertProductFinalPriceIs100_2
		$I->seeElement("//span[@class='price-label'][contains(text(),'As low as')]"); // stepKey: assertAsLowAsPriceLabel_1
		$I->seeElement("//span[@class='price-label'][contains(text(),'As low as')]/following::span[contains(text(), '82')]"); // stepKey: assertPriceAfterAsLowAsLabel_1
		$I->amOnPage("customer/account/logout/"); // stepKey: logoutCustomer2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad7
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToCategoryPage6
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad8
		$I->seeElement("//span[@data-price-type='finalPrice']//span[@class='price'][contains(.,'100')]"); // stepKey: assertProductFinalPriceIs100_3
		$I->seeElement("//span[@class='price-label'][contains(text(),'As low as')]"); // stepKey: assertAsLowAsPriceLabel_2
		$I->seeElement("//span[@class='price-label'][contains(text(),'As low as')]/following::span[contains(text(), '82')]"); // stepKey: assertPriceAfterAsLowAsLabel_2
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad9
		$I->seeElement("//ul[contains(@class, 'prices-tier')]//li[1][contains(text(),'Buy 15 for')]"); // stepKey: assertProductTierPriceByForTextLabelForFirstRow1
		$I->seeElement("//ul[contains(@class, 'prices-tier')]//li[2][contains(text(),'Buy 20 for')]"); // stepKey: assertProductTierPriceByForTextLabelForSecondRow1
		$I->seeElement("//ul[contains(@class, 'prices-tier')]//li[1]//span[contains(text(), '90')]"); // stepKey: assertProductTierPriceAmountForFirstRow1
		$I->seeElement("//ul[contains(@class, 'prices-tier')]//li[2]//span[contains(text(), '82')]"); // stepKey: assertProductTierPriceAmountForSecondRow1
		$I->seeElement("//ul[contains(@class, 'prices-tier')]//li[1]//span[contains(@class, 'percent')][contains(text(), '10')]"); // stepKey: assertProductTierPriceSavePercentageAmountForFirstRow1
		$I->seeElement("//ul[contains(@class, 'prices-tier')]//li[2]//span[contains(@class, 'percent')][contains(text(), '18')]"); // stepKey: assertProductTierPriceSavePercentageAmountForSecondRow1
		$I->fillField("#qty", "10"); // stepKey: fillProductQuantity1
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Entering Action Group [goToCheckoutFromMinicart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartGoToCheckoutFromMinicartWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartGoToCheckoutFromMinicart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleGoToCheckoutFromMinicartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartGoToCheckoutFromMinicartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToCheckoutFromMinicart
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlGoToCheckoutFromMinicart
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "10"); // stepKey: seeInQtyField10
		$grabTextFromSubtotalField1 = $I->grabTextFrom("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'subtotal')]//span[@class='price']"); // stepKey: grabTextFromSubtotalField1
		$I->assertEquals("$1,000.00", $grabTextFromSubtotalField1, "Shopping cart should contain subtotal $1,000"); // stepKey: assertSubtotalField1
		$I->fillField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "15"); // stepKey: fillProductQuantity2
		$I->click("#form-validate button[type='submit'].update"); // stepKey: clickUpdateShoppingCartButton1
		$I->waitForPageLoad(30); // stepKey: clickUpdateShoppingCartButton1WaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappear1
		$grabTextFromSubtotalField2 = $I->grabTextFrom("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'subtotal')]//span[@class='price']"); // stepKey: grabTextFromSubtotalField2
		$I->assertEquals("$1,350.00", $grabTextFromSubtotalField2, "Shopping cart should contain subtotal $1,350"); // stepKey: assertSubtotalField2
		$I->fillField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "20"); // stepKey: fillProductQuantity3
		$I->click("#form-validate button[type='submit'].update"); // stepKey: clickUpdateShoppingCartButton2
		$I->waitForPageLoad(30); // stepKey: clickUpdateShoppingCartButton2WaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappear2
		$grabTextFromSubtotalField3 = $I->grabTextFrom("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'subtotal')]//span[@class='price']"); // stepKey: grabTextFromSubtotalField3
		$I->assertEquals("$1,640.00", $grabTextFromSubtotalField3, "Shopping cart should contain subtotal $1,640"); // stepKey: assertSubtotalField3
		$I->comment("Tier Price is changed in Shopping Cart and is changed on Product page if Tier Price parameters are changed in Admin");
		$I->comment("Entering Action Group [navigateToProductIndex4] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex4
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex4
		$I->comment("Exiting Action Group [navigateToProductIndex4] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [openEditProduct4] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProduct4
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct4
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct4
		$I->comment("Exiting Action Group [openEditProduct4] OpenEditProductOnBackendActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPage4
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButton4
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButton4WaitForPageLoad
		$I->waitForElement("[data-action='add_new_row']", 30); // stepKey: waitForcustomerGroupPriceAddButton4
		$I->waitForPageLoad(30); // stepKey: waitForcustomerGroupPriceAddButton4WaitForPageLoad
		$I->fillField("[name='product[tier_price][1][percentage_value]']", "25"); // stepKey: selectProductTierPricePercentageValue2
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButton4
		$I->waitForPageLoad(30); // stepKey: clickDoneButton4WaitForPageLoad
		$I->comment("Entering Action Group [saveProduct4] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct4
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct4
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct4WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct4
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct4WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct4
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct4
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct4
		$I->comment("Exiting Action Group [saveProduct4] SaveProductFormActionGroup");
		$I->comment("Entering Action Group [goToShoppingCartPage1] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToShoppingCartPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToShoppingCartPage1
		$I->comment("Exiting Action Group [goToShoppingCartPage1] StorefrontCartPageOpenActionGroup");
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "20"); // stepKey: seeInQtyField20
		$grabTextFromSubtotalField4 = $I->grabTextFrom("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'subtotal')]//span[@class='price']"); // stepKey: grabTextFromSubtotalField4
		$I->assertEquals("$1,500.00", $grabTextFromSubtotalField4, "Shopping cart should contain subtotal $1,500"); // stepKey: assertSubtotalField4
		$grabTextFromCheckoutCartSummarySectionSubtotal1 = $I->grabTextFrom("//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: grabTextFromCheckoutCartSummarySectionSubtotal1
		$I->assertEquals("$1,500.00", $grabTextFromCheckoutCartSummarySectionSubtotal1, "Shopping cart summary section should contain subtotal $1,500"); // stepKey: assertSubtotalFieldFromCheckoutCartSummarySection1
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCart1
		$I->waitForElementVisible(".block-minicart .amount span.price", 30); // stepKey: waitForminiCartSubtotalField1
		$grabTextFromMiniCartSubtotalField = $I->grabTextFrom(".block-minicart .amount span.price"); // stepKey: grabTextFromMiniCartSubtotalField
		$I->assertEquals("$1,500.00", $grabTextFromMiniCartSubtotalField, "Mini shopping cart should contain subtotal $1,500"); // stepKey: assertSubtotalFieldFromMiniShoppingCart1
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/sales/#sales_msrp-link"); // stepKey: navigateToAdminSalesConfigPageMAPTab1
		$I->waitForPageLoad(30); // stepKey: waitForAdminSalesConfigPageLoad1
		$I->uncheckOption("#sales_msrp_enabled_inherit"); // stepKey: uncheckMAPUseSystemValue
		$I->selectOption("#sales_msrp_enabled", "Yes"); // stepKey: setEnableMAPYes
		$I->click("#save"); // stepKey: saveConfig1
		$I->see("You saved the configuration.", "#messages div.message-success"); // stepKey: seeConfigSuccessMessage1
		$I->comment("Entering Action Group [flushCache1] ClearCacheActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/cache"); // stepKey: goToCacheManagementFlushCache1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadFlushCache1
		$I->click("#flush_magento"); // stepKey: clickFlushMagentoCacheFlushCache1
		$I->waitForPageLoad(30); // stepKey: waitForCacheFlushFlushCache1
		$I->comment("Exiting Action Group [flushCache1] ClearCacheActionGroup");
		$I->comment("Entering Action Group [goToShoppingCartPage2] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToShoppingCartPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToShoppingCartPage2
		$I->comment("Exiting Action Group [goToShoppingCartPage2] StorefrontCartPageOpenActionGroup");
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "20"); // stepKey: seeInQtyField20_2
		$grabTextFromSubtotalField5 = $I->grabTextFrom("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'subtotal')]//span[@class='price']"); // stepKey: grabTextFromSubtotalField5
		$I->assertEquals("$1,500.00", $grabTextFromSubtotalField5, "Shopping cart should contain subtotal $1,500"); // stepKey: assertSubtotalField5
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/sales/#sales_msrp-link"); // stepKey: navigateToAdminSalesConfigPageMAPTab2
		$I->waitForPageLoad(30); // stepKey: waitForAdminSalesConfigPageLoad2
		$I->selectOption("#sales_msrp_enabled", "No"); // stepKey: setEnableMAPNo
		$I->click("#save"); // stepKey: saveConfig2
		$I->see("You saved the configuration.", "#messages div.message-success"); // stepKey: seeConfigSuccessMessage2
		$I->comment("Entering Action Group [flushCache2] ClearCacheActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/cache"); // stepKey: goToCacheManagementFlushCache2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadFlushCache2
		$I->click("#flush_magento"); // stepKey: clickFlushMagentoCacheFlushCache2
		$I->waitForPageLoad(30); // stepKey: waitForCacheFlushFlushCache2
		$I->comment("Exiting Action Group [flushCache2] ClearCacheActionGroup");
		$I->comment("Entering Action Group [goToShoppingCartPage3] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToShoppingCartPage3
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToShoppingCartPage3
		$I->comment("Exiting Action Group [goToShoppingCartPage3] StorefrontCartPageOpenActionGroup");
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "20"); // stepKey: seeInQtyField20_3
		$grabTextFromSubtotalField6 = $I->grabTextFrom("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'subtotal')]//span[@class='price']"); // stepKey: grabTextFromSubtotalField6
		$I->assertEquals("$1,500.00", $grabTextFromSubtotalField6, "Shopping cart should contain subtotal $1,500"); // stepKey: assertSubtotalField6
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad10
		$I->seeElement("//ul[contains(@class, 'prices-tier')]//li[1][contains(text(),'Buy 15 for')]"); // stepKey: assertProductTierPriceByForTextLabelForFirstRow2
		$I->seeElement("//ul[contains(@class, 'prices-tier')]//li[2][contains(text(),'Buy 20 for')]"); // stepKey: assertProductTierPriceByForTextLabelForSecondRow2
		$I->seeElement("//ul[contains(@class, 'prices-tier')]//li[1]//span[contains(text(), '90')]"); // stepKey: assertProductTierPriceAmountForFirstRow2
		$I->seeElement("//ul[contains(@class, 'prices-tier')]//li[2]//span[contains(text(), '75')]"); // stepKey: assertProductTierPriceAmountForSecondRow2
		$I->seeElement("//ul[contains(@class, 'prices-tier')]//li[1]//span[contains(@class, 'percent')][contains(text(), '10')]"); // stepKey: assertProductTierPriceSavePercentageAmountForFirstRow2
		$I->seeElement("//ul[contains(@class, 'prices-tier')]//li[2]//span[contains(@class, 'percent')][contains(text(), '25')]"); // stepKey: assertProductTierPriceSavePercentageAmountForSecondRow2
		$I->comment("Entering Action Group [navigateToProductIndex5] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex5
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex5
		$I->comment("Exiting Action Group [navigateToProductIndex5] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [openEditProduct5] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProduct5
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct5
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct5
		$I->comment("Exiting Action Group [openEditProduct5] OpenEditProductOnBackendActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPage5
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButton5
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButton5WaitForPageLoad
		$I->waitForElement("[data-action='remove_row']", 30); // stepKey: waitForcustomerGroupPriceDeleteButton
		$I->waitForPageLoad(30); // stepKey: waitForcustomerGroupPriceDeleteButtonWaitForPageLoad
		$I->scrollTo("(//*[contains(@class, 'product_form_product_form_advanced_pricing_modal')]//tr//button[@data-action='remove_row'])[1]", 30, 0); // stepKey: scrollToDeleteFirstRowOfCustomerGroupPrice
		$I->click("(//tr//button[@data-action='remove_row'])[1]", ".product_form_product_form_advanced_pricing_modal"); // stepKey: deleteFirstRowOfCustomerGroupPrice
		$I->click("//tr//button[@data-action='remove_row']", ".product_form_product_form_advanced_pricing_modal"); // stepKey: deleteSecondRowOfCustomerGroupPrice
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary", ".product_form_product_form_advanced_pricing_modal"); // stepKey: clickDoneButton5
		$I->waitForPageLoad(30); // stepKey: clickDoneButton5WaitForPageLoad
		$I->comment("Entering Action Group [saveProduct5] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct5
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct5
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct5WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct5
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct5WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct5
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct5
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct5
		$I->comment("Exiting Action Group [saveProduct5] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPage6
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButton6
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButton6WaitForPageLoad
		$I->waitForElement("[data-action='add_new_row']", 30); // stepKey: waitForcustomerGroupPriceAddButton5
		$I->waitForPageLoad(30); // stepKey: waitForcustomerGroupPriceAddButton5WaitForPageLoad
		$I->dontSeeElement("[name='product[tier_price][0][price_qty]']"); // stepKey: dontSeeQtyInputOfFirstRow
		$I->dontSeeElement("[name='product[tier_price][1][price_qty]']"); // stepKey: dontSeeQtyInputOfSecondRow
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-close"); // stepKey: closeAdvancedPricingPopup
		$I->waitForPageLoad(30); // stepKey: closeAdvancedPricingPopupWaitForPageLoad
		$I->waitForElementVisible(".admin__field[data-index=price] input", 30); // stepKey: waitForAdminProductFormSectionProductPriceInput
		$I->fillField(".admin__field[data-index=price] input", "200"); // stepKey: fillProductPrice200
		$I->comment("Entering Action Group [clickSaveButton] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveButton
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] AdminProductFormSaveActionGroup");
		$I->comment("Entering Action Group [goToShoppingCartPage4] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToShoppingCartPage4
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToShoppingCartPage4
		$I->comment("Exiting Action Group [goToShoppingCartPage4] StorefrontCartPageOpenActionGroup");
		$grabTextFromSubtotalField7 = $I->grabTextFrom("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'subtotal')]//span[@class='price']"); // stepKey: grabTextFromSubtotalField7
		$I->assertEquals("$4,000.00", $grabTextFromSubtotalField7, "Shopping cart should contain subtotal $4,000"); // stepKey: assertSubtotalField7
		$grabTextFromCheckoutCartSummarySectionSubtotal2 = $I->grabTextFrom("//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: grabTextFromCheckoutCartSummarySectionSubtotal2
		$I->assertEquals("$4,000.00", $grabTextFromCheckoutCartSummarySectionSubtotal2, "Shopping cart summary section should contain subtotal $4,000"); // stepKey: assertSubtotalFieldFromCheckoutCartSummarySection2
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCart2
		$I->waitForElementVisible(".block-minicart .amount span.price", 30); // stepKey: waitForminiCartSubtotalField2
		$grabTextFromMiniCartSubtotalField2 = $I->grabTextFrom(".block-minicart .amount span.price"); // stepKey: grabTextFromMiniCartSubtotalField2
		$I->assertEquals("$4,000.00", $grabTextFromMiniCartSubtotalField2, "Mini shopping cart should contain subtotal $4,000"); // stepKey: assertSubtotalFieldFromMiniShoppingCart2
	}
}
