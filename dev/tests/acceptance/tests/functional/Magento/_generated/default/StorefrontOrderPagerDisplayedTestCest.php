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
 * @Title("MC-16167: Pager is displayed for 21 order items")
 * @Description("Pager is displayed for 21 order items<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/StorefrontOrderPagerDisplayedTest.xml<br>")
 * @TestCaseId("MC-16167")
 * @group sales
 * @group mtf_migrated
 */
class StorefrontOrderPagerDisplayedTestCest
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
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->comment("21 products created and category");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct01", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct01
		$I->createEntity("createProduct02", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct02
		$I->createEntity("createProduct03", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct03
		$I->createEntity("createProduct04", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct04
		$I->createEntity("createProduct05", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct05
		$I->createEntity("createProduct06", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct06
		$I->createEntity("createProduct07", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct07
		$I->createEntity("createProduct08", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct08
		$I->createEntity("createProduct09", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct09
		$I->createEntity("createProduct10", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct10
		$I->createEntity("createProduct11", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct11
		$I->createEntity("createProduct12", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct12
		$I->createEntity("createProduct13", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct13
		$I->createEntity("createProduct14", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct14
		$I->createEntity("createProduct15", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct15
		$I->createEntity("createProduct16", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct16
		$I->createEntity("createProduct17", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct17
		$I->createEntity("createProduct18", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct18
		$I->createEntity("createProduct19", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct19
		$I->createEntity("createProduct20", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct20
		$I->createEntity("createProduct21", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct21
		$I->comment("Customer is created");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete category and products");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct01", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("createProduct02", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("createProduct03", "hook"); // stepKey: deleteProduct3
		$I->deleteEntity("createProduct04", "hook"); // stepKey: deleteProduct4
		$I->deleteEntity("createProduct05", "hook"); // stepKey: deleteProduct5
		$I->deleteEntity("createProduct06", "hook"); // stepKey: deleteProduct6
		$I->deleteEntity("createProduct07", "hook"); // stepKey: deleteProduct7
		$I->deleteEntity("createProduct08", "hook"); // stepKey: deleteProduct8
		$I->deleteEntity("createProduct09", "hook"); // stepKey: deleteProduct9
		$I->deleteEntity("createProduct10", "hook"); // stepKey: deleteProduct10
		$I->deleteEntity("createProduct11", "hook"); // stepKey: deleteProduct11
		$I->deleteEntity("createProduct12", "hook"); // stepKey: deleteProduct12
		$I->deleteEntity("createProduct13", "hook"); // stepKey: deleteProduct13
		$I->deleteEntity("createProduct14", "hook"); // stepKey: deleteProduct14
		$I->deleteEntity("createProduct15", "hook"); // stepKey: deleteProduct15
		$I->deleteEntity("createProduct16", "hook"); // stepKey: deleteProduct16
		$I->deleteEntity("createProduct17", "hook"); // stepKey: deleteProduct17
		$I->deleteEntity("createProduct18", "hook"); // stepKey: deleteProduct18
		$I->deleteEntity("createProduct19", "hook"); // stepKey: deleteProduct19
		$I->deleteEntity("createProduct20", "hook"); // stepKey: deleteProduct20
		$I->deleteEntity("createProduct21", "hook"); // stepKey: deleteProduct21
		$I->comment("Delete Customer");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
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
	 * @Stories({"Storefront order pager"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Sales"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontOrderPagerDisplayedTest(AcceptanceTester $I)
	{
		$I->comment("Login to Storefront as Customer");
		$I->comment("Entering Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginAsCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginAsCustomer
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginAsCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginAsCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginAsCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginAsCustomer
		$I->comment("Exiting Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->comment("Customer placed the order with 20 products");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->scrollTo("//*[@id='authenticationPopup']/following-sibling::div[3]//*[@id='limiter']"); // stepKey: scrollToLimiter
		$I->selectOption("//*[@id='authenticationPopup']/following-sibling::div[3]//*[@id='limiter']", "36"); // stepKey: selectLimitOnPage
		$I->waitForPageLoad(30); // stepKey: waitForLoadProducts
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPage
		$I->comment("Entering Action Group [addProduct1] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct01', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollAddProduct1
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct01', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProduct1
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct01', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProduct1
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxAddProduct1
		$I->comment("Exiting Action Group [addProduct1] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->comment("Entering Action Group [addProduct2] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct02', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollAddProduct2
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct02', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProduct2
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct02', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProduct2
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxAddProduct2
		$I->comment("Exiting Action Group [addProduct2] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->comment("Entering Action Group [addProduct3] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct03', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollAddProduct3
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct03', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProduct3
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct03', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProduct3
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxAddProduct3
		$I->comment("Exiting Action Group [addProduct3] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->comment("Entering Action Group [addProduct4] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct04', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollAddProduct4
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct04', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProduct4
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct04', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProduct4
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxAddProduct4
		$I->comment("Exiting Action Group [addProduct4] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->comment("Entering Action Group [addProduct5] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct05', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollAddProduct5
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct05', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProduct5
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct05', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProduct5
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxAddProduct5
		$I->comment("Exiting Action Group [addProduct5] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->comment("Entering Action Group [addProduct6] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct06', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollAddProduct6
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct06', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProduct6
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct06', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProduct6
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxAddProduct6
		$I->comment("Exiting Action Group [addProduct6] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->comment("Entering Action Group [addProduct7] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct07', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollAddProduct7
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct07', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProduct7
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct07', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProduct7
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxAddProduct7
		$I->comment("Exiting Action Group [addProduct7] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->comment("Entering Action Group [addProduct8] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct08', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollAddProduct8
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct08', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProduct8
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct08', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProduct8
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxAddProduct8
		$I->comment("Exiting Action Group [addProduct8] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->comment("Entering Action Group [addProduct9] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct09', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollAddProduct9
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct09', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProduct9
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct09', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProduct9
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxAddProduct9
		$I->comment("Exiting Action Group [addProduct9] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->comment("Entering Action Group [addProduct10] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct10', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollAddProduct10
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct10', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProduct10
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct10', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProduct10
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxAddProduct10
		$I->comment("Exiting Action Group [addProduct10] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->comment("Entering Action Group [addProduct11] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct11', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollAddProduct11
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct11', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProduct11
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct11', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProduct11
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxAddProduct11
		$I->comment("Exiting Action Group [addProduct11] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->comment("Entering Action Group [addProduct12] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct12', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollAddProduct12
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct12', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProduct12
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct12', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProduct12
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxAddProduct12
		$I->comment("Exiting Action Group [addProduct12] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->comment("Entering Action Group [addProduct13] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct13', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollAddProduct13
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct13', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProduct13
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct13', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProduct13
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxAddProduct13
		$I->comment("Exiting Action Group [addProduct13] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->comment("Entering Action Group [addProduct14] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct14', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollAddProduct14
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct14', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProduct14
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct14', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProduct14
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxAddProduct14
		$I->comment("Exiting Action Group [addProduct14] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->comment("Entering Action Group [addProduct15] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct15', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollAddProduct15
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct15', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProduct15
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct15', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProduct15
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxAddProduct15
		$I->comment("Exiting Action Group [addProduct15] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->comment("Entering Action Group [addProduct16] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct16', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollAddProduct16
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct16', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProduct16
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct16', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProduct16
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxAddProduct16
		$I->comment("Exiting Action Group [addProduct16] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->comment("Entering Action Group [addProduct17] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct17', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollAddProduct17
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct17', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProduct17
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct17', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProduct17
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxAddProduct17
		$I->comment("Exiting Action Group [addProduct17] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->comment("Entering Action Group [addProduct18] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct18', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollAddProduct18
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct18', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProduct18
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct18', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProduct18
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxAddProduct18
		$I->comment("Exiting Action Group [addProduct18] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->comment("Entering Action Group [addProduct19] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct19', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollAddProduct19
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct19', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProduct19
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct19', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProduct19
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxAddProduct19
		$I->comment("Exiting Action Group [addProduct19] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->comment("Entering Action Group [addProduct20] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct20', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollAddProduct20
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct20', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProduct20
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct20', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProduct20
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxAddProduct20
		$I->comment("Exiting Action Group [addProduct20] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->comment("Entering Action Group [addProduct21] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct21', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollAddProduct21
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct21', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProduct21
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct21', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProduct21
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxAddProduct21
		$I->comment("Exiting Action Group [addProduct21] StorefrontAddProductToCartFromCategoryActionGroup");
		$I->comment("Place Order");
		$I->comment("Entering Action Group [onCheckout] StorefrontOpenCheckoutPageActionGroup");
		$I->amOnPage("/checkout"); // stepKey: openCheckoutPageOnCheckout
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPageLoadedOnCheckout
		$I->comment("Exiting Action Group [onCheckout] StorefrontOpenCheckoutPageActionGroup");
		$I->see("21", ".items-in-cart > .title > strong > span"); // stepKey: see21Products
		$I->comment("Entering Action Group [clickNextButton] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickNextButton
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickNextButtonWaitForPageLoad
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToNextButtonClickNextButton
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonClickNextButtonWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextClickNextButton
		$I->waitForPageLoad(30); // stepKey: clickNextClickNextButtonWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearClickNextButton
		$I->comment("Exiting Action Group [clickNextButton] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: placeOrder
		$I->waitForPageLoad(30); // stepKey: placeOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccess
		$grabOrderNumber = $I->grabTextFrom(".order-number>strong"); // stepKey: grabOrderNumber
		$I->comment("Go to My Account > My Orders page");
		$I->comment("Entering Action Group [onMyAccount] StorefrontOpenMyAccountPageActionGroup");
		$I->amOnPage("/customer/account/"); // stepKey: goToMyAccountPageOnMyAccount
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOnMyAccount
		$I->comment("Exiting Action Group [onMyAccount] StorefrontOpenMyAccountPageActionGroup");
		$I->click("//div[@id='block-collapsible-nav']//a[text()='My Orders']"); // stepKey: clickOnMyOrders
		$I->waitForPageLoad(60); // stepKey: clickOnMyOrdersWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrdersLoad
		$I->comment("Click 'View Order' link on order from preconditions");
		$I->click("//td[contains(text(),'{$grabOrderNumber}')]/following-sibling::td[contains(@class,'col') and contains(@class,'actions')]/a[contains(@class, 'view')]"); // stepKey: clickOrderView
		$I->waitForPageLoad(30); // stepKey: clickOrderViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageLoad
		$I->comment("Assert: Pager is displayed for 21 order items");
		$I->seeElement(".pager"); // stepKey: assertPagerIsDisplayed
	}
}
