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
 * @Title("[NO TESTCASEID]: Admin disabling swatch tooltips test.")
 * @Description("Verify possibility to disable/enable swatch tooltips.<h3>Test files</h3>app/code/Magento/Swatches/Test/Mftf/Test/AdminDisablingSwatchTooltipsTest.xml<br>")
 * @group Swatches
 */
class AdminDisablingSwatchTooltipsTestCest
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
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->comment("Log in");
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
		$I->waitForPageLoad(30); // stepKey: waitToClickSave
		$I->click("#save_and_edit_button"); // stepKey: clickSaveAndEdit
		$I->waitForPageLoad(30); // stepKey: clickSaveAndEditWaitForPageLoad
		$I->comment("Log out");
		$I->comment("Entering Action Group [logOut] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogOut
		$I->comment("Exiting Action Group [logOut] AdminLogoutActionGroup");
		$I->comment("Delete category");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Enable swatch tooltips");
		$disableTooltips = $I->magentoCLI("config:set catalog/frontend/show_swatch_tooltip 1", 60); // stepKey: disableTooltips
		$I->comment($disableTooltips);
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
	 * @Features({"Swatches"})
	 * @Stories({"Swatch Tooltip Status Change"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDisablingSwatchTooltipsTest(AcceptanceTester $I)
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
		$I->comment("Set swatch using the color picker");
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
		$I->waitForPageLoad(30); // stepKey: waitToClickSave
		$I->comment("Save");
		$I->click("#save_and_edit_button"); // stepKey: clickSaveAndEdit1
		$I->waitForPageLoad(30); // stepKey: clickSaveAndEdit1WaitForPageLoad
		$I->waitForElementVisible(".message.message-success.success", 30); // stepKey: waitForSuccess
		$I->comment("Assert that the Save was successful after round trip to server");
		$I->comment("Entering Action Group [assertSwatchAdmin] AssertSwatchColorActionGroup");
		$grabStyle1AssertSwatchAdmin = $I->grabAttributeFrom("#swatch-visual-options-panel table tbody tr:nth-of-type(1) .swatch_window", "style"); // stepKey: grabStyle1AssertSwatchAdmin
		$I->assertEquals("background: rgb(231, 77, 60);", $grabStyle1AssertSwatchAdmin); // stepKey: assertStyle1AssertSwatchAdmin
		$I->comment("Exiting Action Group [assertSwatchAdmin] AssertSwatchColorActionGroup");
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
		$I->comment("Create configurations based on the Swatch we created earlier");
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
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSku
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "99"); // stepKey: enterAttributeQuantity
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3WaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickOnSaveButton2
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButton2WaitForPageLoad
		$I->conditionalClick("button[data-index='confirm_button']", "button[data-index='confirm_button']", true); // stepKey: clickOnConfirmInPopup
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmInPopupWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveProductMessage
		$I->seeInTitle("testProductName" . msq("_defaultProduct")); // stepKey: seeProductNameInTitle
		$I->comment("Go to the product page and see swatch options");
		$I->amOnPage("testproductname" . msq("_defaultProduct") . ".html"); // stepKey: amOnProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPage
		$I->comment("Verify that the storefront shows the swatches too");
		$I->comment("Entering Action Group [assertSwatchStorefront] AssertStorefrontSwatchColorActionGroup");
		$grabStyle1AssertSwatchStorefront = $I->grabAttributeFrom("div.swatch-option:nth-of-type(1)", "style"); // stepKey: grabStyle1AssertSwatchStorefront
		$I->assertEquals("background: center center no-repeat rgb(231, 77, 60);", $grabStyle1AssertSwatchStorefront); // stepKey: assertStyle1AssertSwatchStorefront
		$I->comment("Exiting Action Group [assertSwatchStorefront] AssertStorefrontSwatchColorActionGroup");
		$I->comment("Verify swatch tooltips are visible");
		$I->moveMouseOver("div.swatch-option:nth-of-type(1)"); // stepKey: hoverEnabledSwatch
		$I->wait(1); // stepKey: waitForTooltip1
		$I->seeElement("div.swatch-option-tooltip"); // stepKey: swatchTooltipVisible
		$I->comment("Disable swatch tooltips");
		$disableTooltips = $I->magentoCLI("config:set catalog/frontend/show_swatch_tooltip 0", 60); // stepKey: disableTooltips
		$I->comment($disableTooltips);
		$I->comment("Entering Action Group [flushCacheAfterDisabling] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushCacheAfterDisabling = $I->magentoCLI("cache:flush", 60, "config full_page"); // stepKey: flushSpecifiedCacheFlushCacheAfterDisabling
		$I->comment($flushSpecifiedCacheFlushCacheAfterDisabling);
		$I->comment("Exiting Action Group [flushCacheAfterDisabling] CliCacheFlushActionGroup");
		$I->comment("Verify swatch tooltips are not visible");
		$I->comment("Entering Action Group [refreshPage] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageRefreshPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadRefreshPage
		$I->comment("Exiting Action Group [refreshPage] ReloadPageActionGroup");
		$I->comment("Replacing reload action and preserve Backward Compatibility");
		$I->moveMouseOver("div.swatch-option:nth-of-type(1)"); // stepKey: hoverDisabledSwatch
		$I->wait(1); // stepKey: waitForTooltip2
		$I->dontSeeElement("div.swatch-option-tooltip"); // stepKey: swatchTooltipNotVisible
	}
}
