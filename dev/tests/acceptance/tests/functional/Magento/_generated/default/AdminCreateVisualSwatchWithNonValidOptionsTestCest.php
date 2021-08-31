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
 * @Title("MC-4140: Admin should be able to create swatch product attribute")
 * @Description("Admin should be able to create swatch product attribute<h3>Test files</h3>app/code/Magento/Swatches/Test/Mftf/Test/AdminCreateVisualSwatchWithNonValidOptionsTest.xml<br>")
 * @TestCaseId("MC-4140")
 * @group Swatches
 */
class AdminCreateVisualSwatchWithNonValidOptionsTestCest
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
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Remove attribute");
		$I->comment("Entering Action Group [deleteAttribute] DeleteProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteAttribute
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAttributeWaitForPageLoad
		$I->fillField("#attributeGrid_filter_attribute_code", "visual_swatch_attr" . msq("visualSwatchAttribute")); // stepKey: setAttributeCodeDeleteAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridDeleteAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2DeleteAttribute
		$I->click("#delete"); // stepKey: deleteAttributeDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: deleteAttributeDeleteAttributeWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: ClickOnDeleteButtonDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: ClickOnDeleteButtonDeleteAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteAttribute
		$I->seeElement(".message.message-success.success"); // stepKey: waitForSuccessMessageDeleteAttribute
		$I->comment("Exiting Action Group [deleteAttribute] DeleteProductAttributeActionGroup");
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
	 * @Features({"Swatches"})
	 * @Stories({"Create/configure swatches product attribute"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateVisualSwatchWithNonValidOptionsTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToNewProductAttributePage] AdminNavigateToNewProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute/new/"); // stepKey: goToNewProductAttributePageNavigateToNewProductAttributePage
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadNavigateToNewProductAttributePage
		$I->comment("Exiting Action Group [navigateToNewProductAttributePage] AdminNavigateToNewProductAttributePageActionGroup");
		$I->comment("Set attribute properties");
		$I->fillField("#attribute_label", "VisualSwatchAttr" . msq("visualSwatchAttribute")); // stepKey: fillDefaultLabel
		$I->selectOption("#frontend_input", "Visual Swatch"); // stepKey: fillInputType
		$I->comment("Set advanced attribute properties");
		$I->click("#advanced_fieldset-wrapper"); // stepKey: showAdvancedAttributePropertiesSection
		$I->waitForElementVisible("#attribute_code", 30); // stepKey: waitForSlideOut
		$I->fillField("#attribute_code", "visual_swatch_attr" . msq("visualSwatchAttribute")); // stepKey: fillAttributeCode
		$I->comment("Add new swatch option without label");
		$I->click("#add_new_swatch_visual_option_button"); // stepKey: clickAddSwatch1
		$I->waitForPageLoad(30); // stepKey: clickAddSwatch1WaitForPageLoad
		$I->comment("Entering Action Group [clickSwatch1] OpenSwatchMenuByIndexActionGroup");
		$I->comment("I had to use executeJS to perform the click to get around the use of CSS ::before and ::after");
		$clickSwatch1ClickSwatch1 = $I->executeJS("jQuery('#swatch_window_option_option_0').click()"); // stepKey: clickSwatch1ClickSwatch1
		$I->comment("Exiting Action Group [clickSwatch1] OpenSwatchMenuByIndexActionGroup");
		$I->click("#swatch-visual-options-panel table tbody tr:nth-of-type(1) .swatch_row_name.colorpicker_handler"); // stepKey: clickChooseColor1
		$I->comment("Entering Action Group [fillHex1] SetColorPickerByHexActionGroup");
		$I->comment("This 6x backspace stuff is some magic that is necessary to interact with this field correctly");
		$I->pressKey("//div[@class='colorpicker'][1]/div[@class='colorpicker_hex']/input", \Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,'ff0000'); // stepKey: fillHex1FillHex1
		$I->click("//div[@class='colorpicker'][1]/div[@class='colorpicker_submit']"); // stepKey: submitColor1FillHex1
		$I->comment("Exiting Action Group [fillHex1] SetColorPickerByHexActionGroup");
		$I->comment("Save the new product attribute");
		$I->click("#save"); // stepKey: clickSave1
		$I->waitForPageLoad(30); // stepKey: clickSave1WaitForPageLoad
		$I->waitForElementVisible(".message.message-error.error", 30); // stepKey: waitForError
		$I->comment("Fill options data");
		$I->fillField("optionvisual[value][option_0][0]", "red"); // stepKey: fillAdmin1
		$I->comment("Add 2 additional new swatch options");
		$I->click("#add_new_swatch_visual_option_button"); // stepKey: clickAddSwatch2
		$I->waitForPageLoad(30); // stepKey: clickAddSwatch2WaitForPageLoad
		$I->comment("Entering Action Group [clickSwatch2] OpenSwatchMenuByIndexActionGroup");
		$I->comment("I had to use executeJS to perform the click to get around the use of CSS ::before and ::after");
		$clickSwatch1ClickSwatch2 = $I->executeJS("jQuery('#swatch_window_option_option_1').click()"); // stepKey: clickSwatch1ClickSwatch2
		$I->comment("Exiting Action Group [clickSwatch2] OpenSwatchMenuByIndexActionGroup");
		$I->click("#swatch-visual-options-panel table tbody tr:nth-of-type(2) .swatch_row_name.colorpicker_handler"); // stepKey: clickChooseColor2
		$I->comment("Entering Action Group [fillHex2] SetColorPickerByHexActionGroup");
		$I->comment("This 6x backspace stuff is some magic that is necessary to interact with this field correctly");
		$I->pressKey("//div[@class='colorpicker'][2]/div[@class='colorpicker_hex']/input", \Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,'00ff00'); // stepKey: fillHex1FillHex2
		$I->click("//div[@class='colorpicker'][2]/div[@class='colorpicker_submit']"); // stepKey: submitColor1FillHex2
		$I->comment("Exiting Action Group [fillHex2] SetColorPickerByHexActionGroup");
		$I->fillField("optionvisual[value][option_1][0]", "green"); // stepKey: fillAdmin2
		$I->click("#add_new_swatch_visual_option_button"); // stepKey: clickAddSwatch3
		$I->waitForPageLoad(30); // stepKey: clickAddSwatch3WaitForPageLoad
		$I->comment("Entering Action Group [clickSwatch3] OpenSwatchMenuByIndexActionGroup");
		$I->comment("I had to use executeJS to perform the click to get around the use of CSS ::before and ::after");
		$clickSwatch1ClickSwatch3 = $I->executeJS("jQuery('#swatch_window_option_option_2').click()"); // stepKey: clickSwatch1ClickSwatch3
		$I->comment("Exiting Action Group [clickSwatch3] OpenSwatchMenuByIndexActionGroup");
		$I->click("#swatch-visual-options-panel table tbody tr:nth-of-type(3) .swatch_row_name.colorpicker_handler"); // stepKey: clickChooseColor3
		$I->comment("Entering Action Group [fillHex3] SetColorPickerByHexActionGroup");
		$I->comment("This 6x backspace stuff is some magic that is necessary to interact with this field correctly");
		$I->pressKey("//div[@class='colorpicker'][3]/div[@class='colorpicker_hex']/input", \Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,'0000ff'); // stepKey: fillHex1FillHex3
		$I->click("//div[@class='colorpicker'][3]/div[@class='colorpicker_submit']"); // stepKey: submitColor1FillHex3
		$I->comment("Exiting Action Group [fillHex3] SetColorPickerByHexActionGroup");
		$I->fillField("optionvisual[value][option_2][0]", "blue"); // stepKey: fillAdmin3
		$I->comment("Mark second option as default");
		$I->click("(//input[@name='defaultvisual[]'])[2]"); // stepKey: setSecondOptionAsDefault
		$I->comment("Go to Storefront Properties tab");
		$I->scrollToTopOfPage(); // stepKey: scrollToTop
		$I->click("#product_attribute_tabs_front"); // stepKey: goToStorefrontPropertiesTab
		$I->waitForElementVisible("//span[text()='Storefront Properties']", 30); // stepKey: waitTabLoad
		$I->comment("Save the new product attribute");
		$I->click("#save"); // stepKey: clickSave2
		$I->waitForPageLoad(30); // stepKey: clickSave2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: waitForSuccessMessage
		$I->comment("Entering Action Group [navigateToAttribute] NavigateToCreatedProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridNavigateToAttribute
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersNavigateToAttribute
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersNavigateToAttributeWaitForPageLoad
		$I->fillField("#attributeGrid_filter_attribute_code", "visual_swatch_attr" . msq("visualSwatchAttribute")); // stepKey: setAttributeCodeNavigateToAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridNavigateToAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridNavigateToAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowNavigateToAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowNavigateToAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToAttribute
		$I->comment("Exiting Action Group [navigateToAttribute] NavigateToCreatedProductAttributeActionGroup");
		$I->comment("Check attribute data");
		$I->seeCheckboxIsChecked("(//input[@name='defaultvisual[]'])[2]"); // stepKey: CheckDefaultOption
	}
}
