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
 * @Title("MC-3085: Customer can change product options using swatches")
 * @Description("Customer can change product options using swatches<h3>Test files</h3>app/code/Magento/Swatches/Test/Mftf/Test/StorefrontCustomerCanChangeProductOptionsUsingSwatchesTest.xml<br>")
 * @TestCaseId("MC-3085")
 * @group swatches
 */
class StorefrontCustomerCanChangeProductOptionsUsingSwatchesTestCest
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
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Clean up our modifications to the existing color attribute");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Entering Action Group [goToProductAttributes] AdminOpenProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: goToAttributePageGoToProductAttributes
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadGoToProductAttributes
		$I->comment("Exiting Action Group [goToProductAttributes] AdminOpenProductAttributePageActionGroup");
		$I->fillField("#attributeGrid_filter_attribute_code", "color"); // stepKey: fillFilter
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickSearch
		$I->waitForPageLoad(30); // stepKey: clickSearchWaitForPageLoad
		$I->click("//td[contains(text(),'color')]"); // stepKey: clickRowToEdit
		$I->waitForPageLoad(30); // stepKey: clickRowToEditWaitForPageLoad
		$I->click("#swatch-visual-options-panel table tbody tr:nth-of-type(1) button.delete-option"); // stepKey: deleteSwatch1
		$I->click("#swatch-visual-options-panel table tbody tr:nth-of-type(2) button.delete-option"); // stepKey: deleteSwatch2
		$I->click("#swatch-visual-options-panel table tbody tr:nth-of-type(3) button.delete-option"); // stepKey: deleteSwatch3
		$I->waitForPageLoad(30); // stepKey: waitToClickSave
		$I->click("#save_and_edit_button"); // stepKey: clickSaveAndEdit
		$I->waitForPageLoad(30); // stepKey: clickSaveAndEditWaitForPageLoad
		$I->comment("Logout");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
		$I->comment("Logout customer");
		$I->comment("Entering Action Group [logoutStorefront] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutStorefront
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutStorefront
		$I->comment("Exiting Action Group [logoutStorefront] StorefrontCustomerLogoutActionGroup");
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
	 * @Features({"Swatches"})
	 * @Stories({"Swatches"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCustomerCanChangeProductOptionsUsingSwatchesTest(AcceptanceTester $I)
	{
		$I->comment("Go to the edit page for the \"color\" attribute");
		$I->comment("Entering Action Group [goToProductAttributes] AdminOpenProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: goToAttributePageGoToProductAttributes
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadGoToProductAttributes
		$I->comment("Exiting Action Group [goToProductAttributes] AdminOpenProductAttributePageActionGroup");
		$I->fillField("#attributeGrid_filter_attribute_code", "color"); // stepKey: fillFilter
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickSearch
		$I->waitForPageLoad(30); // stepKey: clickSearchWaitForPageLoad
		$I->click("//td[contains(text(),'color')]"); // stepKey: clickRowToEdit
		$I->waitForPageLoad(30); // stepKey: clickRowToEditWaitForPageLoad
		$I->comment("Change to visual swatches");
		$I->selectOption("select[name='frontend_input']", "swatch_visual"); // stepKey: selectVisualSwatch
		$I->waitForPageLoad(30); // stepKey: selectVisualSwatchWaitForPageLoad
		$I->comment("Set swatch #1 using the color picker");
		$I->click("#add_new_swatch_visual_option_button"); // stepKey: clickAddSwatch1
		$I->waitForPageLoad(30); // stepKey: clickAddSwatch1WaitForPageLoad
		$I->comment("Entering Action Group [clickSwatch1] OpenSwatchMenuByIndexActionGroup");
		$I->comment("I had to use executeJS to perform the click to get around the use of CSS ::before and ::after");
		$clickSwatch1ClickSwatch1 = $I->executeJS("jQuery('#swatch_window_option_option_0').click()"); // stepKey: clickSwatch1ClickSwatch1
		$I->comment("Exiting Action Group [clickSwatch1] OpenSwatchMenuByIndexActionGroup");
		$I->click("#swatch-visual-options-panel table tbody tr:nth-of-type(1) .swatch_row_name.colorpicker_handler"); // stepKey: clickChooseColor1
		$I->comment("Entering Action Group [fillHex1] SetColorPickerByHexActionGroup");
		$I->comment("This 6x backspace stuff is some magic that is necessary to interact with this field correctly");
		$I->pressKey("//div[@class='colorpicker'][1]/div[@class='colorpicker_hex']/input", \Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,'e74c3c'); // stepKey: fillHex1FillHex1
		$I->click("//div[@class='colorpicker'][1]/div[@class='colorpicker_submit']"); // stepKey: submitColor1FillHex1
		$I->comment("Exiting Action Group [fillHex1] SetColorPickerByHexActionGroup");
		$I->fillField("optionvisual[value][option_0][0]", "red"); // stepKey: fillAdmin1
		$I->comment("Set swatch #2 using the color picker");
		$I->click("#add_new_swatch_visual_option_button"); // stepKey: clickAddSwatch2
		$I->waitForPageLoad(30); // stepKey: clickAddSwatch2WaitForPageLoad
		$I->comment("Entering Action Group [clickSwatch2] OpenSwatchMenuByIndexActionGroup");
		$I->comment("I had to use executeJS to perform the click to get around the use of CSS ::before and ::after");
		$clickSwatch1ClickSwatch2 = $I->executeJS("jQuery('#swatch_window_option_option_1').click()"); // stepKey: clickSwatch1ClickSwatch2
		$I->comment("Exiting Action Group [clickSwatch2] OpenSwatchMenuByIndexActionGroup");
		$I->click("#swatch-visual-options-panel table tbody tr:nth-of-type(2) .swatch_row_name.colorpicker_handler"); // stepKey: clickChooseColor2
		$I->comment("Entering Action Group [fillHex2] SetColorPickerByHexActionGroup");
		$I->comment("This 6x backspace stuff is some magic that is necessary to interact with this field correctly");
		$I->pressKey("//div[@class='colorpicker'][2]/div[@class='colorpicker_hex']/input", \Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,'2ecc71'); // stepKey: fillHex1FillHex2
		$I->click("//div[@class='colorpicker'][2]/div[@class='colorpicker_submit']"); // stepKey: submitColor1FillHex2
		$I->comment("Exiting Action Group [fillHex2] SetColorPickerByHexActionGroup");
		$I->fillField("optionvisual[value][option_1][0]", "green"); // stepKey: fillAdmin2
		$I->comment("Set swatch #3 using the color picker");
		$I->click("#add_new_swatch_visual_option_button"); // stepKey: clickAddSwatch3
		$I->waitForPageLoad(30); // stepKey: clickAddSwatch3WaitForPageLoad
		$I->comment("Entering Action Group [clickSwatch3] OpenSwatchMenuByIndexActionGroup");
		$I->comment("I had to use executeJS to perform the click to get around the use of CSS ::before and ::after");
		$clickSwatch1ClickSwatch3 = $I->executeJS("jQuery('#swatch_window_option_option_2').click()"); // stepKey: clickSwatch1ClickSwatch3
		$I->comment("Exiting Action Group [clickSwatch3] OpenSwatchMenuByIndexActionGroup");
		$I->click("#swatch-visual-options-panel table tbody tr:nth-of-type(3) .swatch_row_name.colorpicker_handler"); // stepKey: clickChooseColor3
		$I->comment("Entering Action Group [fillHex3] SetColorPickerByHexActionGroup");
		$I->comment("This 6x backspace stuff is some magic that is necessary to interact with this field correctly");
		$I->pressKey("//div[@class='colorpicker'][3]/div[@class='colorpicker_hex']/input", \Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,'3498db'); // stepKey: fillHex1FillHex3
		$I->click("//div[@class='colorpicker'][3]/div[@class='colorpicker_submit']"); // stepKey: submitColor1FillHex3
		$I->comment("Exiting Action Group [fillHex3] SetColorPickerByHexActionGroup");
		$I->fillField("optionvisual[value][option_2][0]", "blue"); // stepKey: fillAdmin3
		$I->waitForPageLoad(30); // stepKey: waitToClickSave
		$I->comment("Save");
		$I->click("#save_and_edit_button"); // stepKey: clickSaveAndEdit1
		$I->waitForPageLoad(30); // stepKey: clickSaveAndEdit1WaitForPageLoad
		$I->waitForElementVisible(".message.message-success.success", 30); // stepKey: waitForSuccess
		$I->comment("Assert that the Save was successful after round trip to server");
		$I->comment("Entering Action Group [assertSwatch1] AssertSwatchColorActionGroup");
		$grabStyle1AssertSwatch1 = $I->grabAttributeFrom("#swatch-visual-options-panel table tbody tr:nth-of-type(1) .swatch_window", "style"); // stepKey: grabStyle1AssertSwatch1
		$I->assertEquals("background: rgb(231, 77, 60);", $grabStyle1AssertSwatch1); // stepKey: assertStyle1AssertSwatch1
		$I->comment("Exiting Action Group [assertSwatch1] AssertSwatchColorActionGroup");
		$I->comment("Entering Action Group [assertSwatch2] AssertSwatchColorActionGroup");
		$grabStyle1AssertSwatch2 = $I->grabAttributeFrom("#swatch-visual-options-panel table tbody tr:nth-of-type(2) .swatch_window", "style"); // stepKey: grabStyle1AssertSwatch2
		$I->assertEquals("background: rgb(46, 204, 112);", $grabStyle1AssertSwatch2); // stepKey: assertStyle1AssertSwatch2
		$I->comment("Exiting Action Group [assertSwatch2] AssertSwatchColorActionGroup");
		$I->comment("Entering Action Group [assertSwatch3] AssertSwatchColorActionGroup");
		$grabStyle1AssertSwatch3 = $I->grabAttributeFrom("#swatch-visual-options-panel table tbody tr:nth-of-type(3) .swatch_window", "style"); // stepKey: grabStyle1AssertSwatch3
		$I->assertEquals("background: rgb(52, 152, 219);", $grabStyle1AssertSwatch3); // stepKey: assertStyle1AssertSwatch3
		$I->comment("Exiting Action Group [assertSwatch3] AssertSwatchColorActionGroup");
		$I->comment("Create a configurable product to verify the storefront with");
		$I->comment("Entering Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAmOnProductGridPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAmOnProductGridPage
		$I->comment("Exiting Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [clickOnAddConfigurableProduct] AdminClickAddProductToggleAndSelectProductTypeActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownClickOnAddConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownClickOnAddConfigurableProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-configurable']"); // stepKey: clickAddProductClickOnAddConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadClickOnAddConfigurableProduct
		$I->comment("Exiting Action Group [clickOnAddConfigurableProduct] AdminClickAddProductToggleAndSelectProductTypeActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: fillName
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: fillSKU
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillPrice
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillQuantity
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'test')]); // stepKey: fillCategory
		$I->waitForPageLoad(30); // stepKey: fillCategoryWaitForPageLoad
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: openSeoSection
		$I->waitForPageLoad(30); // stepKey: openSeoSectionWaitForPageLoad
		$I->fillField("input[name='product[url_key]']", "testproductname" . msq("_defaultProduct")); // stepKey: fillUrlKey
		$I->comment("Create configurations based off the Text Swatch we created earlier");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickCreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickCreateConfigurationsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFilters
		$I->fillField(".admin__control-text[name='attribute_code']", "color"); // stepKey: fillFilterAttributeCodeField
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButton
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckbox
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1WaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAll
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2WaitForPageLoad
		$I->click(".admin__field-label[for='apply-unique-prices-radio']"); // stepKey: clickOnApplyUniquePricesByAttributeToEachSku
		$I->selectOption("#select-each-price", "Color"); // stepKey: selectAttributes
		$I->waitForPageLoad(30); // stepKey: selectAttributesWaitForPageLoad
		$I->fillField("#apply-single-price-input-0", "10"); // stepKey: fillAttributePrice1
		$I->fillField("#apply-single-price-input-1", "20"); // stepKey: fillAttributePrice2
		$I->fillField("#apply-single-price-input-2", "30"); // stepKey: fillAttributePrice3
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSku
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "99"); // stepKey: enterAttributeQuantity
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3WaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickOnSaveButton2
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButton2WaitForPageLoad
		$I->comment("conditionalClick is necessary because this popup appears in Jenkins but not locally. I cannot figure out why.");
		$I->conditionalClick("button[data-index='confirm_button']", "button[data-index='confirm_button']", true); // stepKey: clickOnConfirmInPopup
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmInPopupWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveProductMessage
		$I->seeInTitle("testProductName" . msq("_defaultProduct")); // stepKey: seeProductNameInTitle
		$I->comment("Go to the product page and see text swatch options");
		$I->comment("Entering Action Group [loginCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginCustomer
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginCustomer
		$I->comment("Exiting Action Group [loginCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("testproductname" . msq("_defaultProduct") . ".html"); // stepKey: amOnProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPage
		$I->comment("Verify that the storefront shows the swatches too");
		$I->comment("Remove steps that are not used for this test");
		$I->comment("Login to storefront from customer");
		$I->comment("Add configurable product with swatch attribute to the cart");
		$I->comment("Entering Action Group [addConfigurableProductToTheCart] StorefrontAddProductWithSwatchesToTheCartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadAddConfigurableProductToTheCart
		$I->click(".swatch-option[data-option-tooltip-value='#3498db']"); // stepKey: clickSelectOptionAddConfigurableProductToTheCart
		$I->fillField("input.input-text.qty", "1"); // stepKey: fillProduct1QuantityAddConfigurableProductToTheCart
		$I->waitForPageLoad(30); // stepKey: fillProduct1QuantityAddConfigurableProductToTheCartWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToCartButtonAddConfigurableProductToTheCart
		$I->waitForPageLoad(60); // stepKey: clickOnAddToCartButtonAddConfigurableProductToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToAddInCartAddConfigurableProductToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddConfigurableProductToTheCart
		$I->see("You added testProductName" . msq("_defaultProduct") . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddConfigurableProductToTheCart
		$I->comment("Exiting Action Group [addConfigurableProductToTheCart] StorefrontAddProductWithSwatchesToTheCartActionGroup");
		$I->comment("Go to shopping cart and update option of configurable product");
		$I->comment("Entering Action Group [openShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageOpenShoppingCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenShoppingCartPage
		$I->comment("Exiting Action Group [openShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [updateConfigurableProductInTheCart] StorefrontUpdateCartConfigurableProductWithSwatchesActionGroup");
		$I->click(".item:nth-of-type(1) .action-edit"); // stepKey: clickEditConfigurableProductButtonUpdateConfigurableProductInTheCart
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadUpdateConfigurableProductInTheCart
		$I->click(".swatch-option[data-option-tooltip-value='#e74d3c']"); // stepKey: changeSwatchAttributeOptionUpdateConfigurableProductInTheCart
		$I->click("button#product-updatecart-button"); // stepKey: clickUpdateCartButtonUpdateConfigurableProductInTheCart
		$I->waitForPageLoad(30); // stepKey: clickUpdateCartButtonUpdateConfigurableProductInTheCartWaitForPageLoad
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageUpdateConfigurableProductInTheCart
		$I->see("testProductName" . msq("_defaultProduct") . " was updated in your shopping cart.", "div.message-success.success.message"); // stepKey: assertSuccessMessageUpdateConfigurableProductInTheCart
		$I->comment("Exiting Action Group [updateConfigurableProductInTheCart] StorefrontUpdateCartConfigurableProductWithSwatchesActionGroup");
	}
}
