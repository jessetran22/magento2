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
 * @Title("MC-37806: Attributess with reserved codes should not be created")
 * @Description("Admin should not be able to create product attribute with reserved codes<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/CreateProductAttributeEntityTest/CreateProductAttributeEntityWithReservedKeysTest.xml<br>")
 * @TestCaseId("MC-37806")
 * @group catalog
 */
class CreateProductAttributeEntityWithReservedKeysTestCest
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
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
	 * @Features({"Catalog"})
	 * @Stories({"Create Product Attributes"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function CreateProductAttributeEntityWithReservedKeysTest(AcceptanceTester $I)
	{
		$I->comment("Navigate to Stores > Attributes > Product.");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: goToProductAttributesGrid
		$I->comment("Create new Product Attribute as TextField, with type_id code.");
		$I->comment("Entering Action Group [createAttribute] CreateProductAttributeActionGroup");
		$I->click("#add"); // stepKey: createNewAttributeCreateAttribute
		$I->fillField("#attribute_label", "type_id"); // stepKey: fillDefaultLabelCreateAttribute
		$I->selectOption("#frontend_input", "text"); // stepKey: checkInputTypeCreateAttribute
		$I->selectOption("#is_required", "No"); // stepKey: checkRequiredCreateAttribute
		$I->click("#save"); // stepKey: saveAttributeCreateAttribute
		$I->waitForPageLoad(30); // stepKey: saveAttributeCreateAttributeWaitForPageLoad
		$I->comment("Exiting Action Group [createAttribute] CreateProductAttributeActionGroup");
		$I->see("Code (type_id) is a reserved key and cannot be used as attribute code.", ".message.message-error.error"); // stepKey: seeErrorMessage
		$I->comment("Navigate to Stores > Attributes > Product.");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: backToProductAttributesGrid
		$I->comment("Create new Product Attribute as TextField, with product_type code.");
		$I->comment("Entering Action Group [createAttribute2] CreateProductAttributeActionGroup");
		$I->click("#add"); // stepKey: createNewAttributeCreateAttribute2
		$I->fillField("#attribute_label", "product_type"); // stepKey: fillDefaultLabelCreateAttribute2
		$I->selectOption("#frontend_input", "text"); // stepKey: checkInputTypeCreateAttribute2
		$I->selectOption("#is_required", "No"); // stepKey: checkRequiredCreateAttribute2
		$I->click("#save"); // stepKey: saveAttributeCreateAttribute2
		$I->waitForPageLoad(30); // stepKey: saveAttributeCreateAttribute2WaitForPageLoad
		$I->comment("Exiting Action Group [createAttribute2] CreateProductAttributeActionGroup");
		$I->see("Code (product_type) is a reserved key and cannot be used as attribute code.", ".message.message-error.error"); // stepKey: seeErrorMessage2
	}
}
